<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * Create a new Trip
     * @Route("/trip/new", name="trip_new")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $trip = new Trip;
        $tripForm = $this->createForm(TripType::class, $trip);
        $tripForm->handleRequest($request);
        if($tripForm->isSubmitted() && $tripForm->isValid())
        {
           
            $trip->setTraveller($this->getUser())
                 ->setBookingNumber($trip->getBookingNumber());
                 
            $manager->persist($trip);
            $manager->flush();

            $this->addFlash("success", "Félicitations, le trajet {$trip->getDeparture()} - {$trip->getArrival()} a bien été enregistré.");

            return $this->redirectToRoute('trip_view', [
                'slug' => $trip->getSlug()
                ]);

        }
        return $this->render('trip/new.html.twig', [
            'tripForm' => $tripForm->createView()
        ]);
    }

    /**
     * Edit a trip
     * @Route("/trip/{slug}/edit", name="trip_edit")
     * @Security("is_granted('ROLE_RENTER') and user === trip.getTraveller()", message="Ce voyage n'est pas le tien. Tu ne peux donc pas le modifier.")
     * @Security("is_granted('ROLE_TRAVELLER') and user === trip.getTraveller()", message="Ce voyage n'est pas le tien. Tu ne peux donc pas le modifier.")
     * @return Response
     */
    public function edit(Trip $trip, Request $request, ObjectManager $manager)
    {
        $tripForm = $this->createForm(TripType::class, $trip);
        $tripForm->handleRequest($request);
        if($tripForm->isSubmitted() && $tripForm->isValid())
        {  
            $manager->persist($trip);
            $manager->flush();

            $this->addFlash("success", "Félicitations, les modifications du trajet {$trip->getDeparture()} {$trip->getArrival()} ont bien été enregistrées.");

            return $this->redirectToRoute('trip_view', [
                'slug' => $trip->getSlug()
                ]);

        }
        return $this->render('trip/edit.html.twig', [
            'trip'     => $trip,
            'tripForm' => $tripForm->createView()
        ]);
    }

    /**
     * View one trip
     * @Route("/trip/{slug}", name="trip_view")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
     * @return Response
     */
    public function view(Trip $trip)
    {

        return $this->render('trip/view.html.twig', [
            'trip' => $trip
        ]);
    }

    /**
     * Delete one trip
     * @Route("/trip/{slug}/delete", name="trip_delete")
     *  @Security("is_granted('ROLE_RENTER') and user === trip.getTraveller()", message="Ce voyage n'est pas le tien. Tu ne peux donc pas le supprimer.")
     * @Security("is_granted('ROLE_TRAVELLER') and user === trip.getTraveller()", message="Ce voyage n'est pas le tien. Tu ne peux donc pas le supprimer.")
     * @param Trip $trip
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Trip $trip, ObjectManager $manager)
    {
        $manager->remove($trip);
        $manager->flush();

        $this->addFlash("success", "Félicitations, la suppression  du trajet {$trip->getDeparture()} {$trip->getArrival()} a bien été enregistrée.");
        return $this->redirectToRoute('trip_index');
    }
}
