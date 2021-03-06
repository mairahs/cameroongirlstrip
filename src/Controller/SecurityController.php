<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SecurityType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends AbstractController
{
    /**
     * Avoid to log in to the site
     * @Route("/login", name="security_login")
     * @return Response
     */
    public function login(AuthenticationUtils $tools)
    {
        $error = $tools->getLastAuthenticationError();
        $username = $tools->getLastUsername();
        return $this->render('security/login.html.twig', [
            'hasError' => $error !== NULL,
            'username' => $username
        ]);
    }

    /**
     * Avoid to log out to the site
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        
    }

     /**
     * Avoid to register to the site
     * @Route("/register", name="security_register")
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User;
        $userForm = $this->createForm(RegistrationType::class, $user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid())
        {
            $user->setHash($encoder->encodePassword($user, $user->getHash()));
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Félicitations !!! Ton compte a bien été créé. Tu peux maintenant te connecter. Bienvenue parmi nous '. $user->getFirstName().'.');
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/register.html.twig', [
            'user'     => $user,
            'userForm' => $userForm->createView()
        ]);
    }

    /**
     * Avoid to edit and manage the profile of an user
     * @Route("/security/profile", name="security_profile")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();
        $securityForm = $this->createForm(SecurityType::class, $user);
        $securityForm->handleRequest($request);
        if($securityForm->isSubmitted() && $securityForm->isValid())
        {
            $manager->flush();

            $this->addFlash('success', 'Félicitations !!! Ton compte a bien été modifié '. $user->getFirstName().'.');
            return $this->redirectToRoute('user_view');
        }
        return $this->render('security/profile.html.twig', [
            'user'          => $user,
            'securityForm'  => $securityForm->createView()
        ]);
    }
    
    /**
     * Avoid to update user's password
     * @Route("/security/password-update", name="security_password")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function updatePassword(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate;
        $user = $this->getUser();
        $passwordUpdateForm = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $passwordUpdateForm->handleRequest($request);
        if($passwordUpdateForm->isSubmitted() && $passwordUpdateForm->isValid())
        {
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash()))
            {
                $passwordUpdateForm->get('oldPassword')->addError(new FormError("Le mot de passe que tu as renseigné n'est pas ton mot de passe actuel."));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $user->setHash($encoder->encodePassword($user,$newPassword));
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Félicitations !!! Ton mot de passe a bien été modifié '. $user->getFirstName().'.');
            return $this->redirectToRoute('user_view');
            }        
        }
        
        return $this->render('security/password.html.twig', [
            'user'                => $user,
            'passwordUpdate'      => $passwordUpdate,
            'passwordUpdateForm'  => $passwordUpdateForm->createView()
        ]);
    }

    /**
     * Avoid to display loggued user's profile
     * @Route("/security/my-account", name="security_account")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function myAccount()
    {
        $user = $this->getUser();
        return $this->render('user/view.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * Avoid to display all loggued user's adbookings
     * @Route("/security/my-adbookings", name="security_adbookings")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return AdBooking []
     */
    public function myAdBookings()
    {
        return $this->render('security/index_adBookings.html.twig');
    }
    
     /**
     * Avoid to display all loggued user's tripbookings
     * @Route("/security/my-tripbookings", name="security_tripbookings")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return TripBooking []
     */
    public function myTripBookings()
    {
        return $this->render('security/index_tripBookings.html.twig');
    }
    

    
}
