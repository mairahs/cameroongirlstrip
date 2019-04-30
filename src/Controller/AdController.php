<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\AdSearch;
use App\Entity\AdContact;
use App\Form\AnnonceType;
use App\Form\AdSearchType;
use App\Form\AdContactType;
use App\Repository\AdRepository;
use App\Notification\AdContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * View all ads
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repository, Request $request, PaginatorInterface $paginator)
    {
    
        $adSearch = new AdSearch;
        $adSearchForm = $this->createForm(AdSearchType::class, $adSearch);
        $adSearchForm->handleRequest($request);
        $ads = $paginator->paginate($repository->getAllAdsSearch($adSearch),
                $request->query->getInt('page', 1), 5);
                
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
            'adSearchForm' => $adSearchForm->createView()
        ]);
    }

    /**
     * Create a new Ad
     * @Route("/ad/new", name="ad_new")
     * @isGranted("ROLE_TRAVELLER", message="Hélas, tu n'as pas accès à cette ressource.")
     * @isGranted("ROLE_RENTER",  message="Hélas, tu n'as pas accès à cette ressource.")
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
            $ad->setAuthor($this->getUser()); 
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
     * @Security("is_granted('ROLE_RENTER') and user === ad.getAuthor()", message="Cette annonce n'est pas la tienne. Tu ne peux donc pas la modifier.")
     * @Security("is_granted('ROLE_TRAVELLER') and user === ad.getAuthor()", message="Cette annonce n'est pas la tienne. Tu ne peux donc pas la modifier.")
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
    public function view(Ad $ad, AdContactNotification $notification, Request $request)
    {
        
        $adContact = new AdContact;
        $adContact->setAd($ad);
        $adContactForm = $this->createForm(AdContactType::class, $adContact);
        $adContactForm->handleRequest($request);
        if ( $adContactForm->isSubmitted() &&  $adContactForm->isValid())
        {
            $notification->notify($adContact);
            $this->addFlash("success", "Ton email a bien été envoyé à {$adContact->getAd()->getAuthor()->getFirstName()}.");
            return $this->redirectToRoute('ad_view', [
                 'slug' => $ad->getSlug()
                 ]);
        }
        return $this->render('ad/view.html.twig', [
            'ad' => $ad,
            'adContactForm' => $adContactForm->createView()
        ]);
    }

     /**
     * Delete one ad
     * @Route("/ad/{slug}/delete", name="ad_delete")
     * @Security("is_granted('ROLE_RENTER') and user === ad.getAuthor()", message="Cette annonce n'est pas la tienne. Tu ne peux donc pas la supprimer.")
     * @Security("is_granted('ROLE_TRAVELLER') and user === ad.getAuthor()", message="Cette annonce n'est pas la tienne. Tu ne peux donc pas la supprimer.")
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Ad $ad, ObjectManager $manager)
    {
        $manager->remove($ad);
        $manager->flush();

        $this->addFlash("success", "Félicitations, la suppression  de ton annonce {$ad->getTitle()} a bien été enregistrée.");
        return $this->redirectToRoute('ad_index');
    }
}
