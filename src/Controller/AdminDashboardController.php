<?php

namespace App\Controller;

use App\Statistics\Statistics;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admindashboard")
     */
    public function index(ObjectManager $manager, Statistics $statistics)
    {
        $stats      = $statistics->getStats();
        $bestAds    = $statistics->getAdsStats('DESC');
        $worstAds   = $statistics->getAdsStats('ASC');
        $bestTrips  = $statistics->getTripsStats('DESC');
        $worstTrips = $statistics->getTripsStats('ASC');
        

        return $this->render('admin/dashboard/index.html.twig', [
        	'stats'      => $stats,
        	'bestAds'    => $bestAds,
            'worstAds'   => $worstAds,
            'bestTrips'  => $bestTrips,
            'worstTrips' => $worstTrips
        ]);
    }
}
