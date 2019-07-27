<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class LoginController extends AbstractController
{
    /**
     * Login Page
     * @Route("/login",name="login")
     */
    public function loginUser()
    {
        return $this->render(
            'pages/login.html.twig',
            ['curent_menu' => 'login']
        );
    }
}
