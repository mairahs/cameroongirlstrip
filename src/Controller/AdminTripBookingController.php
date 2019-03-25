<?php

namespace App\Controller;

use App\Entity\TripBooking;
use App\Form\AdminTripBookingType;
use App\Repository\TripBookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTripBookingController extends AbstractController
{
    /**
     * avoid to display all tripbookings
     * @Route("/admin/tripbooking/tripbookings", name="admintripbooking_index")
     */
    public function index(TripBookingRepository $repository)
    {
        $tripBookings = $repository->findAll();
        return $this->render('admin/tripbooking/index.html.twig', [
            'tripBookings' => $tripBookings
        ]);
    }

    
    /**
     * avoid to edit tripbooking
     * @Route("/admin/tripbooking/{id}/edit", name="admintripbooking_edit")
     */
    public function edit(TripBooking $tripBooking, Request $request, ObjectManager $manager)
    {
        $adminTripBookingForm = $this->createForm(AdminTripBookingType::class, $tripBooking);
        $adminTripBookingForm ->handleRequest($request);

        if($adminTripBookingForm ->isSubmitted() && $adminTripBookingForm ->isValid())
        {
            $tripBooking->setAmount(0);
            $manager->flush();

            $this->addFlash('success', "La réservation numéro {$tripBooking->getId()} a bien été modifiée");
        }
        return $this->render('admin/tripbooking/edit.html.twig', [
            'tripBooking' => $tripBooking,
            'adminTripBookingForm' => $adminTripBookingForm->createView()
        ]);
    }

    /**
     * avoid delete one tripbooking
     * @Route("/admin/tripbooking/{id}/delete", name="admintripbooking_delete")
     * @return Response
     */
    public function delete(TripBooking $tripBooking, ObjectManager $manager)
    {
        $manager->remove($tripBooking);
        $this->addFlash('success', "La réservation numéro {$tripBooking->getId()} a bien été supprimée");
        $manager->flush();

        return $this->redirectToRoute('admintripbooking_index');
    }
}
