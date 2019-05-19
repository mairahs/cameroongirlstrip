<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AdRepository;
use App\Repository\TripRepository;
use App\Repository\AdCommentRepository;
use App\Repository\TripCommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
 
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
     * @Route("/user/trips/{slug}", name="user_indexTrips")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     */
    public function indexTripsUser(User $user, TripRepository $tripRepository)
    {
        $tripsOnUser = $tripRepository->getAllTripsByUser($user);
        return $this->render('user/indexTrips.html.twig', [
            'user' => $user,
            'tripsOnUser' => $tripsOnUser
        ]);
    }

    /**
     * @Route("/user/ads/{slug}", name="user_indexAds")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     */
    public function indexAdsUser(User $user, AdRepository $adRepository)
    {
        $adsOnUser = $adRepository->getAllAdsByUser($user);
        return $this->render('user/indexAds.html.twig', [
            'user' => $user,
            'adsOnUser' => $adsOnUser
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

    /**
     * @Route("/user/adcomments/{slug}", name="user_indexAdComments")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     */
    public function indexAdCommentsUser(User $user, AdCommentRepository $adCommentRepository)
    {
        $adCommentsOnUser = $adCommentRepository->getAdCommentsOnUser($user);
        return $this->render('user/indexAdComments.html.twig', [
            'user' => $user,
            'adCommentsOnUser' => $adCommentsOnUser
        ]);
    }
}

