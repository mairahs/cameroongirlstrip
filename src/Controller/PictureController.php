<?php

namespace App\Controller;

use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PictureController extends AbstractController
{
   /**
     * Delete one picture
     * @Route("/picture/{id}/delete", name="picture_delete")
     * @Security("is_granted('ROLE_RENTER') and user === picture.getAd().getAuthor()", message="Cette image n'est pas la tienne. Tu ne peux donc pas la supprimer.")
     * @Security("is_granted('ROLE_TRAVELLER') and user === picture.getAd().getAuthor()", message="Cette image n'est pas la tienne. Tu ne peux donc pas la supprimer.")
     * @param Picture $picture
     * @return Response
     */
    public function delete(Picture $picture, Request $request, ObjectManager $manager)
    {
        $data = json_decode($request->getContent(), true);
    
        if($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token']))
        {
            $manager->remove($picture);
            $manager->flush();
            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['error' => 'Token invalide'], 400);
       
    }
}
