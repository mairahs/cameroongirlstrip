<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Repository\TripRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripController extends AbstractController
{
    /**
     * View all trips
     * @Route("/trips", name="trip_index")
     */
    public function index(TripRepository $repository)
    {
        $trips = $repository->findAll();
        return $this->render('trip/index.html.twig', [
            'trips' => $trips
        ]);
    }

    /**
     * View one trip
     * @Route("/trip/{slug}", name="trip_view")
     * @return Response
     */
    public function view(Trip $trip)
    {
        return $this->render('trip/view.html.twig', [
            'trip' => $trip
        ]);
    }
}
