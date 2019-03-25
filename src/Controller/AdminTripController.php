<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTripController extends AbstractController
{
    /**
     * avoid to display all trips
     * @Route("/admin/trip/trips", name="admintrip_index")
     */
    public function index(TripRepository $repository)
    {
        $trips = $repository->findAll();
        return $this->render('admin/trip/index.html.twig', [
            'trips' => $trips
        ]);
    }
    
    /**
     * avoid to edit trip
     * @Route("/admin/trip/{id}/edit", name="admintrip_edit")
     */
    public function edit(Trip $trip, Request $request, ObjectManager $manager)
    {
        $adminTripForm = $this->createForm(TripType::class, $trip);
        $adminTripForm->handleRequest($request);

        if($adminTripForm->isSubmitted() && $adminTripForm->isValid())
        {
            $manager->persist($trip);
            $manager->flush();

            $this->addFlash('success', "Le voyage {$trip->getDeparture()} - {$trip->getArrival()} a bien été modifié");
        }
        return $this->render('admin/trip/edit.html.twig', [
            'trip' => $trip,
            'adminTripForm' => $adminTripForm->createView()
        ]);
    }

    /**
     * avoid delete one trip
     * @Route("/admin/trip/{id}/delete", name="admintrip_delete")
     * @return Response
     */
    public function delete(Trip $trip, ObjectManager $manager)
    {
       if(count($trip->getTripBookings()) > 0)
       {
        $this->addFlash('warning', "Attention, tu ne peux pas supprimer le voyage {$trip->getDeparture()} - {$trip->getArrival()} car il possède des réservations" );
       }else{
        $manager->remove($ad);
        $manager->flush();
        $this->addFlash('success', "le voyage {$trip->getDeparture()} - {$trip->getArrival()} a bien été supprimé");
       }
      
       return $this->redirectToRoute('admintrip_index');
    }
}
