<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecurityController extends AbstractController
{
    /**
     * Avoid to log in to the site
     * @Route("/admin/login", name="adminsecurity_login")
     * @return Response
     */
    public function login(AuthenticationUtils $tools)
    {
        $error = $tools->getLastAuthenticationError();
        $username = $tools->getLastUsername();
        return $this->render('admin/security/login.html.twig', [
            'has_error' => $error !== NULL,
            'username' => $username
        ]);
    }
     /**
     * Avoid to log in to the site
     * @Route("/admin/logout", name="adminsecurity_logout")
     * @return Response
     */
    public function logout()
    {

    }
}
