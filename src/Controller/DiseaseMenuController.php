<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiseaseMenuController extends AbstractController
{
    /**
     * @Route("/disease/menu", name="disease_menu")
     */
    public function index(): Response
    {
        return $this->render('disease_menu/index.html.twig', [
            'controller_name' => 'DiseaseMenuController',
        ]);
    }
}
