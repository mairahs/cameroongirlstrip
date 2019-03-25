<?php

namespace App\Controller;

use App\Entity\TripComment;
use App\Form\TripCommentType;
use App\Repository\TripCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTripCommentController extends AbstractController
{
    /**
     * avoid to display all tripcomments
     * @Route("/admin/tripcomment/tripcomments", name="admintripcomment_index")
     */
    public function index(TripCommentRepository $repository)
    {
        $tripComments = $repository->findAll();
        return $this->render('admin/tripcomment/index.html.twig', [
            'tripComments' => $tripComments
        ]);
    }

    
    /**
     * avoid to edit tripcomment
     * @Route("/admin/tripcomment/{id}/edit", name="admintripcomment_edit")
     */
    public function edit(TripComment $tripComment, Request $request, ObjectManager $manager)
    {
        $adminTripCommentForm = $this->createForm(TripCommentType::class, $tripComment);
        $adminTripCommentForm->handleRequest($request);

        if($adminTripCommentForm->isSubmitted() && $adminTripCommentForm->isValid())
        {
            $manager->persist($tripComment);
            $manager->flush();

            $this->addFlash('success', "Le commentaire numéro {$tripComment->getId()} a bien été modifié");
        }
        return $this->render('admin/tripcomment/edit.html.twig', [
            'tripComment' => $adComment,
            'adminTripCommentForm' => $adminTripCommentForm->createView()
        ]);
    }

    /**
     * avoid delete one tripcomment
     * @Route("/admin/tripcomment/{id}/delete", name="admintripcomment_delete")
     * @return Response
     */
    public function delete(TripComment $tripComment, ObjectManager $manager)
    {
        $manager->remove($tripComment);
        $manager->flush();
        $this->addFlash('success', "Le commentaire numéro {$tripComment->getId()} a bien été supprimé");
 
        return $this->redirectToRoute('admintripcomment_index');
    }
}
