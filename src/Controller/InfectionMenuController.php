<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfectionMenuController extends AbstractController
{
    /**
     * @Route("/infection/menu", name="infection_menu")
     */
    public function index(): Response
    {
        return $this->render('infection_menu/index.html.twig', [
            'controller_name' => 'InfectionMenuController',
        ]);
    }
}
