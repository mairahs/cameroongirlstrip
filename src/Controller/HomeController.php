<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AdRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use App\Repository\AdCommentRepository;
use App\Repository\TripCommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(TripRepository $tripRepository, AdRepository $adRepository, TripCommentRepository $tripCommentRepository, AdCommentRepository $adCommentRepository)
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
        
        // foreach($bestAds as $bestAd)
        // {
        //   $adCommentsOnUser = $adCommentRepository->getAdCommentsOnUser($bestAd['ad']->getAuthor());
        //   dump($adCommentsOnUser);  
        // }

        // dump($bestAds[0]['ad']->getAuthor());
        // die();

        //$adCommentsOnUser = $adCommentRepository->getAdCommentsOnUser($bestAds[0]['ad']->getAuthor());
        $adCommentsOnUser = $adCommentRepository->getAdCommentsOnUser($bestAds[0]['ad']->getAuthor());
      
        return $this->render('home/home.html.twig', [
            'lastTrips'          => $lastTrips,
            'bestAds'            => $bestAds,
            'tripCommentsOnUser' => $tripCommentsOnUser,
            'adCommentsOnUser'   => $adCommentsOnUser
        ]);
    }
}
