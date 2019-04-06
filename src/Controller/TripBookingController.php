<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\TripBooking;
use App\Entity\TripComment;
use App\Form\TripBookingType;
use App\Form\TripCommentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Check\TripBooking\numberPlacesAndPersonsCheck;
use App\Check\TripBooking\travellerDifferentOfBookerCheck;
use App\Check\TripBooking\fullTripCheck;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TripBookingController extends AbstractController
{
    /**
     * Create a new TripBooking
     * @Route("/trip/{slug}/book", name="tripBooking_new")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager, Trip $trip, numberPlacesAndPersonsCheck $check, travellerDifferentOfBookerCheck $difference)
    {
        $tripBooking = new TripBooking($manager);
        $tripBookingForm = $this->createForm(TripBookingType::class, $tripBooking);
        $tripBookingForm->handleRequest($request);

        if($tripBookingForm->isSubmitted() && $tripBookingForm->isValid())
        {         
            $tripBooking->setTripBooker($this->getUser())
                        ->setTrip($trip);
            
            if(!$check->check($tripBooking))
            {
                $this->addFlash('danger', 'Hélas, il n\'y a plus de places disponibles pour ce voyage. Tu peux créer ton propre voyage.');           
            } elseif(!$difference->check($tripBooking))
            {
                $this->addFlash('danger', 'Tu ne peux pas réserver un voyage que tu as toi-même créé. Tu peux réserver un autre voyage.'); 
                return $this->redirectToRoute('trip_index'); 
            } else
            {
                $manager->persist($tripBooking);
                $manager->flush();
    
                $this->addFlash("success", "Félicitations, tu as bien réservé le voyage {$trip->getDeparture()} - {$trip->getArrival()}");
    
                return $this->redirectToRoute('tripbooking_view', [
                    'id'      => $tripBooking->getId(),
                    'success' => true
                    ]);
            }          
        }
        return $this->render('trip_booking/new.html.twig', [
            'trip'            => $trip,
            'tripBookingForm' => $tripBookingForm->createView()
        ]);
    }

    /**
     * View one booking
     * @Route("/tripbooking/{id}", name="tripbooking_view")
     * @Security("is_granted('ROLE_RENTER') and user === tripBooking.getTripBooker()", message="Cette réservation n'est pas la tienne. Tu ne peux donc pas la visualiser.")
     * @Security("is_granted('ROLE_TRAVELLER') and user === tripBooking.gettripBooker()", message="Cette réservation n'est pas la tienne. Tu ne peux donc pas la visualiser.")
     * @param TripBooking $tripBooking
     * @return Response
     */

    public function view(TripBooking $tripBooking,Request $request, ObjectManager $manager)
    {
        $tripComment = new TripComment;

        $tripCommentForm = $this->createForm(TripCommentType::class, $tripComment);

        $tripCommentForm->handleRequest($request);
         if($tripCommentForm->isSubmitted() && $tripCommentForm->isValid())
         {
            $tripComment->setTrip($tripBooking->getTrip())
                        ->setAuthor($this->getUser());
            $manager->persist($tripComment);
            $manager->flush();

            $this->addFlash('success', "{$this->getUser()->getFirstName()}, ton commentaire a bien été pris en compte");
         }

        return $this->render('trip_booking/view.html.twig', [
            'tripBooking'     => $tripBooking,
            'tripCommentForm' => $tripCommentForm->createView()
        ]);
    }

}
