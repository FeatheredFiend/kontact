<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataMenuController extends AbstractController
{
    /**
     * @Route("/data/menu", name="data_menu")
     */
    public function index(): Response
    {
        return $this->render('data_menu/index.html.twig', [
            'controller_name' => 'DataMenuController',
        ]);
    }
}
