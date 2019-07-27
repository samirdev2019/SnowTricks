<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TricksController extends AbstractController
{
    
    /**
     * Page tricks
     * @Route("/tricks",name="tricks")
     */
    public function tricks():Response
    {
        return $this->render('pages/tricks.html.twig',['curent_menu' => 'tricks']);
    }

}