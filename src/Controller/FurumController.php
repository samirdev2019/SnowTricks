<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FurumController extends AbstractController
{
    /**
     * @Route("/furum", name="furum")
     */
    public function index()
    {
        return $this->render('furum/index.html.twig', [
            'controller_name' => 'FurumController',
        ]);
    }
}
