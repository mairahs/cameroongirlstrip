<?php

namespace App\Controller;

use App\Entity\AdBooking;
use App\Form\AdminAdBookingType;
use App\Repository\AdBookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdBookingController extends AbstractController
{
    /**
     * avoid to display all adbookings
     * @Route("/admin/adbooking/adbookings", name="adminadbooking_index")
     * @return array
     */
    public function index(AdBookingRepository $repository)
    {
        $adBookings = $repository->findAll();
        return $this->render('admin/adbooking/index.html.twig', [
            'adBookings' => $adBookings
        ]);
    }

    
    /**
     * avoid to edit adbooking
     * @Route("/admin/adbooking/{id}/edit", name="adminadbooking_edit")
     * @return Response
     */
    public function edit(AdBooking $adBooking, Request $request, ObjectManager $manager)
    {
        $adminAdBookingForm = $this->createForm(AdminAdBookingType::class, $adBooking);
        $adminAdBookingForm ->handleRequest($request);

        if($adminAdBookingForm->isSubmitted() && $adminAdBookingForm ->isValid())
        {   
            $adBooking->setAmount(0);
            $manager->flush();

            $this->addFlash('success', "La réservation numéro {$adBooking->getId()} a bien été modifiée");
        }
        return $this->render('admin/adbooking/edit.html.twig', [
            'adBooking' => $adBooking,
            'adminAdBookingForm' => $adminAdBookingForm->createView()
        ]);
    }

    /**
     * avoid delete one adbooking
     * @Route("/admin/adbooking/{id}/delete", name="adminadbooking_delete")
     * @return Response
     */
    public function delete(AdBooking $adBooking, ObjectManager $manager)
    {
        $manager->remove($adBooking);
        $manager->flush();
        $this->addFlash('success', "La réservation numéro {$adBooking->getId()} a bien été supprimée");
 
        return $this->redirectToRoute('adminadbooking_index');
    }
}
