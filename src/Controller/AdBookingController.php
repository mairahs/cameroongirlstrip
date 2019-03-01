<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdBooking;
use App\Form\AdBookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdBookingController extends AbstractController
{
    /**
     * Create a new AdBooking
     * @Route("/ad/{slug}/book", name="adBooking_new")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager, Ad $ad)
    {
        $adBooking = new AdBooking;
        $adBookingForm = $this->createForm(AdBookingType::class, $adBooking);
        $adBookingForm->handleRequest($request);
        if($adBookingForm->isSubmitted() && $adBookingForm->isValid())
        {
            $adBooking->setAdBooker($this->getUser())
                      ->setAd($ad);
            if(!$adBooking->isBookableDates())
            {
                $this->addFlash('warning', "Le logement n'est pas disponible aux dates que tu as choisies.");
            }else {
                $manager->persist($adBooking);
                $manager->flush();

                $this->addFlash("success", "Félicitations, tu as bien réservé l'annonce {$ad->getTitle()}.");

                return $this->redirectToRoute('adbooking_view', [
                 'id'      => $adBooking->getId(),
                 'success' => true
               ]);
            }

        }
        return $this->render('ad_booking/new.html.twig', [
            'ad'            => $ad,
            'adBookingForm' => $adBookingForm->createView()
        ]);
    }

    /**
     * View one booking
     * @Route("/adbooking/{id}", name="adbooking_view")
     * @param AdBooking $adBooking
     * @return Response
     */
    public function view(AdBooking $adBooking)
    {
        return $this->render('ad_booking/view.html.twig', [
            'adBooking' => $adBooking
        ]);
    }

}
