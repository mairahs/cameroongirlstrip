<?php

namespace App\Controller;

use App\Entity\UserOption;
use App\Form\AdminUserOptionType;
use App\Repository\UserOptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserOptionController extends AbstractController
{
    
    /**
     * avoid to display all useroptions
     * @Route("/admin/useroption/useroptions", name="adminuseroption_index")
     */
    public function index(UserOptionRepository $repository)
    {
        $userOptions = $repository->findAll();
        return $this->render('admin/useroption/index.html.twig', [
            'userOptions' => $userOptions
        ]);
    }

    /**
     * avoid to create a new useroption
     * @Route("/admin/useroption/new", name="adminuseroption_new")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $userOption = new UserOption;
        $adminUserOptionForm = $this->createForm(AdminUserOptionType::class, $userOption);
        $adminUserOptionForm->handleRequest($request);

        if($adminUserOptionForm->isSubmitted() && $adminUserOptionForm->isValid())
        {
            $manager->persist($userOption);
            $manager->flush();

            $this->addFlash('success', "L'option {$userOption->getName()} a bien été créée");
        }

        return $this->render('admin/useroption/new.html.twig', [
            'adminUserOptionForm' => $adminUserOptionForm->createView()
        ]);
    }

    /**
     * avoid to edit useroption
     * @Route("/admin/useroption/{id}/edit", name="adminuseroption_edit")
     */
    public function edit(UserOption $userOption, Request $request, ObjectManager $manager)
    {
        $adminUserOptionForm = $this->createForm(AdminUserOptionType::class, $userOption);
        $adminUserOptionForm->handleRequest($request);

        if($adminUserOptionForm->isSubmitted() && $adminUserOptionForm->isValid())
        {
            $manager->persist($userOption);
            $manager->flush();

            $this->addFlash('success', "L'option {$userOption->getName()} a bien été modifiée");
        }
        return $this->render('admin/useroption/edit.html.twig', [
            'userOption' => $userOption,
            'adminUserOptionForm' => $adminUserOptionForm->createView()
        ]);
    }

    /**
     * avoid delete one useroption
     * @Route("/admin/useroption/{id}/delete", name="adminuseroption_delete")
     * @return Response
     */
    public function delete(UserOption $userOption, ObjectManager $manager)
    {
        $manager->remove($userOption);
        $manager->flush();
        $this->addFlash('success', "L'option {$userOption->getName()} a bien été supprimée");

       return $this->redirectToRoute('adminuseroption_index');
    }
}
