<?php

namespace App\Controller;

use App\Entity\TripOption;
use App\Form\AdminTripOptionType;
use App\Repository\TripOptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTripOptionController extends AbstractController
{
    
    /**
     * avoid to display all tripoptions
     * @Route("/admin/tripoption/tripoptions", name="admintripoption_index")
     */
    public function index(TripOptionRepository $repository)
    {
        $tripOptions = $repository->findAll();
        return $this->render('admin/tripoption/index.html.twig', [
            'tripOptions' => $tripOptions
        ]);
    }

    /**
     * avoid to create a new tripoption
     * @Route("/admin/tripoption/new", name="admintripoption_new")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $tripOption = new TripOption;
        $adminTripOptionForm = $this->createForm(AdminTripOptionType::class, $tripOption);
        $adminTripOptionForm->handleRequest($request);

        if($adminTripOptionForm->isSubmitted() && $adminTripOptionForm->isValid())
        {
            $manager->persist($tripOption);
            $manager->flush();

            $this->addFlash('success', "L'option {$tripOption->getName()} a bien été créée");
        }

        return $this->render('admin/tripoption/new.html.twig', [
            'adminTripOptionForm' => $adminTripOptionForm->createView()
        ]);
    }

    /**
     * avoid to edit tripoption
     * @Route("/admin/tripoption/{id}/edit", name="admintripoption_edit")
     */
    public function edit(TripOption $tripOption, Request $request, ObjectManager $manager)
    {
        $adminTripOptionForm = $this->createForm(AdminTripOptionType::class, $tripOption);
        $adminTripOptionForm->handleRequest($request);

        if($adminTripOptionForm->isSubmitted() && $adminTripOptionForm->isValid())
        {
            $manager->persist($tripOption);
            $manager->flush();

            $this->addFlash('success', "L'option {$tripOption->getName()} a bien été modifiée");
        }
        return $this->render('admin/tripoption/edit.html.twig', [
            'tripOption' => $tripOption,
            'adminTripOptionForm' => $adminTripOptionForm->createView()
        ]);
    }

    /**
     * avoid delete one tripoption
     * @Route("/admin/tripoption/{id}/delete", name="admintripoption_delete")
     * @return Response
     */
    public function delete(TripOption $tripOption, ObjectManager $manager)
    {
        $manager->remove($tripOption);
        $manager->flush();
        $this->addFlash('success', "L'option {$tripOption->getName()} a bien été supprimée");

       return $this->redirectToRoute('admintripoption_index');
    }
}
