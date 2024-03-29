<?php
/**
 * The SecurityController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  SecurityController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/SecurityController.php
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
/**
 * This class allows to controle the security access and authentication of user
 *
 * @category Class
 * @package  SecurityController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/SecurityController.php
 */
class SecurityController extends AbstractController
{
    /**
     * The user can log in after registering and validating his email
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     *
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render(
            'security/login.html.twig',
            [
            'error'=> $error,
            'last_username'=> $lastUsername,
            'message'=>null
            ]
        );
    }
    /**
     * This function allow the user to logout
     *
     * @return           void
     * @Route("/logout", name="app_logout")
     */
    public function logout():void
    {
        throw new \Exception('this shold never reached!');
    }
}
