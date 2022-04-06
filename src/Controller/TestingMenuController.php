<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestingMenuController extends AbstractController
{
    /**
     * @Route("/testing/menu", name="testing_menu")
     */
    public function index(): Response
    {
        return $this->render('testing_menu/index.html.twig', [
            'controller_name' => 'TestingMenuController',
        ]);
    }
}
