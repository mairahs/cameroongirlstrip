<?php

namespace App\Controller;

use App\Entity\AdOption;
use App\Form\AdminAdOptionType;
use App\Repository\AdOptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdOptionController extends AbstractController
{
    
    /**
     * avoid to display all adoptions
     * @Route("/admin/adoption/adoptions", name="adminadoption_index")
     */
    public function index(AdOptionRepository $repository)
    {
        $adOptions = $repository->findAll();
        return $this->render('admin/adoption/index.html.twig', [
            'adOptions' => $adOptions
        ]);
    }

    /**
     * avoid to create a new adoption
     * @Route("/admin/adoption/new", name="adminadoption_new")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $adOption = new AdOption;
        $adminAdOptionForm = $this->createForm(AdminAdOptionType::class, $adOption);
        $adminAdOptionForm->handleRequest($request);

        if($adminAdOptionForm->isSubmitted() && $adminAdOptionForm->isValid())
        {
            $manager->persist($adOption);
            $manager->flush();

            $this->addFlash('success', "L'option {$adOption->getName()} a bien été créée");
        }

        return $this->render('admin/adoption/new.html.twig', [
            'adminAdOptionForm' => $adminAdOptionForm->createView()
        ]);
    }

    /**
     * avoid to edit adoption
     * @Route("/admin/adoption/{id}/edit", name="adminadoption_edit")
     */
    public function edit(AdOption $adOption, Request $request, ObjectManager $manager)
    {
        $adminAdOptionForm = $this->createForm(AdminAdOptionType::class, $adOption);
        $adminAdOptionForm->handleRequest($request);

        if($adminAdOptionForm->isSubmitted() && $adminAdOptionForm->isValid())
        {
            $manager->persist($adOption);
            $manager->flush();

            $this->addFlash('success', "L'option {$adOption->getName()} a bien été modifiée");
        }
        return $this->render('admin/adoption/edit.html.twig', [
            'adOption' => $adOption,
            'adminAdOptionForm' => $adminAdOptionForm->createView()
        ]);
    }

    /**
     * avoid delete one option
     * @Route("/admin/adoption/{id}/delete", name="adminadoption_delete")
     * @return Response
     */
    public function delete(AdOption $adOption, ObjectManager $manager)
    {
        $manager->remove($adOption);
        $manager->flush();
        $this->addFlash('success', "L'option {$adOption->getName()} a bien été supprimée");

       return $this->redirectToRoute('adminadoption_index');
    }
}
