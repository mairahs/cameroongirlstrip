<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AdRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use App\Repository\AdCommentRepository;
use App\Repository\TripCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(TripRepository $tripRepository, AdRepository $adRepository, TripCommentRepository $tripCommentRepository, AdCommentRepository $adCommentRepository, Request $request)
    {
        $lastTrips = $tripRepository->getLastTrips(3);
        $bestAds   = $adRepository->getBestAds(3);
        $tripCommentsOnUser = $tripCommentRepository->getTripCommentsOnUser($lastTrips[0]['trip']->getTraveller());
        $adCommentsOnUser = $adCommentRepository->getAdCommentsOnUser($bestAds[0]['ad']->getAuthor());
      
        return $this->render('home/home.html.twig', [
            'lastTrips'          => $lastTrips,
            'bestAds'            => $bestAds,
            'tripCommentsOnUser' => $tripCommentsOnUser,
            'adCommentsOnUser'   => $adCommentsOnUser
        ]);
    }
}
