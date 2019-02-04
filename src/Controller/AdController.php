<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
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
