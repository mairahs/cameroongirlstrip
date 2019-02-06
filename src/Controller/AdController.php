<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * View all ads
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repository)
    {
        $ads = $repository->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Create a new Ad
     * @Route("/ad/new", name="ad_new")
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $ad = new Ad;
        $image = new Image;
        $adForm = $this->createForm(AnnonceType::class, $ad);
        $adForm->handleRequest($request);
        if($adForm->isSubmitted() && $adForm->isValid())
        {
            foreach($ad->getImages() as $image)
            {
                $image->setAd($ad);
            }  
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash("success", "Félicitations, l'annonce {$ad->getTitle()} a bien été enregistrée.");

            return $this->redirectToRoute('ad_view', [
                'slug' => $ad->getSlug()
                ]);

        }
        return $this->render('ad/new.html.twig', [
            'adForm' => $adForm->createView()
        ]);
    }

    /**
     * Edit a ad
     * @Route("/ad/{slug}/edit", name="ad_edit")
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $adForm = $this->createForm(AnnonceType::class, $ad);
        $adForm->handleRequest($request);
        if($adForm->isSubmitted() && $adForm->isValid())
        {
            foreach($ad->getImages() as $image)
            {
                $image->setAd($ad);
            }  
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash("success", "Félicitations, les mofifications de l'annonce {$ad->getTitle()} ont bien été enregistrées.");

            return $this->redirectToRoute('ad_view', [
                'slug' => $ad->getSlug()
                ]);

        }
        return $this->render('ad/edit.html.twig', [
            'ad'     => $ad,
            'adForm' => $adForm->createView()
        ]);
    }

    /**
     * View one ad
     * @Route("/ad/{slug}", name="ad_view")
     * @return Response
     */
    public function view(Ad $ad)
    {
        return $this->render('ad/view.html.twig', [
            'ad' => $ad
        ]);
    }
}
