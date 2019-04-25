<?php

namespace App\Controller;

use App\Entity\AdComment;
use App\Form\AdCommentType;
use App\Repository\AdCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdCommentController extends AbstractController
{
    /**
     * avoid to display all adcomments
     * @Route("/admin/adcomment/adcomments", name="adminadcomment_index")
     */
    public function index(AdCommentRepository $repository)
    {
        $adComments = $repository->findAll();
        return $this->render('admin/adcomment/index.html.twig', [
            'adComments' => $adComments
        ]);
    }
   
    /**
     * avoid to edit adcomment
     * @Route("/admin/adcomment/{id}/edit", name="adminadcomment_edit")
     */
    public function edit(AdComment $adComment, Request $request, ObjectManager $manager)
    {
        $adminAdCommentForm = $this->createForm(AdCommentType::class, $adComment);
        $adminAdCommentForm->handleRequest($request);

        if($adminAdCommentForm->isSubmitted() && $adminAdCommentForm->isValid())
        {
            $manager->persist($adComment);
            $manager->flush();

            $this->addFlash('success', "Le commentaire numéro {$adComment->getId()} a bien été modifié");
        }
        return $this->render('admin/adcomment/edit.html.twig', [
            'adComment' => $adComment,
            'adminAdCommentForm' => $adminAdCommentForm->createView()
        ]);
    }

    /**
     * avoid delete one adcomment
     * @Route("/admin/adcomment/{id}/delete", name="adminadcomment_delete")
     * @return Response
     */
    public function delete(AdComment $adComment, ObjectManager $manager)
    {
        $manager->remove($adComment);
        $manager->flush();
        $this->addFlash('success', "Le commentaire numéro {$adComment->getId()} a bien été supprimé");
 
        return $this->redirectToRoute('adminadcomment_index');
    }
}
