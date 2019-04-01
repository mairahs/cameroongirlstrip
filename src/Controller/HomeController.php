<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use App\Repository\TripCommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(TripRepository $tripRepository, AdRepository $adRepository, TripCommentRepository $tripCommentRepository)
    {
        $lastTrips = $tripRepository->getLastTrips(4); 
        $bestAds   = $adRepository->getBestAds(4);
        foreach($lastTrips as $lastTrip)
        {
            foreach($lastTrip as $trip)
            {
                $tripCommentsOnUser = $tripCommentRepository->getTripCommentsOnUser($trip->getTraveller());
            }
        }   
        return $this->render('home/home.html.twig', [
            'lastTrips'=> $lastTrips,
            'bestAds'  => $bestAds,
            'tripCommentsOnUser' => $tripCommentsOnUser
        ]);
    }
}
