<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TripCommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/{slug}", name="user_view")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     */
    public function view(User $user)
    {
        return $this->render('user/view.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/tripcomments/{slug}", name="user_indexTripComments")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     */
    public function indexTripCommentsUser(User $user, TripCommentRepository $tripCommentRepository)
    {
        $tripCommentsOnUser = $tripCommentRepository->getTripCommentsOnUser($user);
        return $this->render('user/indexTripComments.html.twig', [
            'user' => $user,
            'tripCommentsOnUser' => $tripCommentsOnUser
        ]);
    }
}

