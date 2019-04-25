<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdOption;
use App\Form\AnnonceType;
use App\Pagination\Pagination;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * avoid to display all ads
     * @Route("/admin/ad/ads/{page}", name="adminad_index", requirements={"page":"\d+"})
     */
    public function index(AdRepository $repository, $page = 1, Pagination $paginator)
    {
        $paginator->setEntityClass(Ad::class)
                  ->setCurrentPage($page);

        $ads         = $paginator->getData();
        $pagesNumber = $paginator->getPages();

        return $this->render('admin/ad/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

    
    /**
     * avoid to edit ad
     * @Route("/admin/ad/{id}/edit", name="adminad_edit")
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $adminAdForm = $this->createForm(AnnonceType::class, $ad);
        $adminAdForm->handleRequest($request);

        if($adminAdForm->isSubmitted() && $adminAdForm->isValid())
        {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "Le logement <strong>{$ad->getTitle()}</strong> a bien été modifié");
        }
        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'adminAdForm' => $adminAdForm->createView()
        ]);
    }

    /**
     * avoid delete one ad
     * @Route("/admin/ad/{id}/delete", name="adminad_delete")
     * @return Response
     */
    public function delete(Ad $ad, ObjectManager $manager)
    {
       if(count($ad->getAdBookings()) > 0)
       {
        $this->addFlash('warning', "Attention, tu ne peux pas supprimer l'annonce {$ad->getTitle()} car elle possède des réservations" );
       }else{
        $manager->remove($ad);
        $manager->flush();
        $this->addFlash('success', "L'annonce {$ad->getTitle()} a bien été supprimée");
       }
      
       return $this->redirectToRoute('adminad_index');
    }
}
