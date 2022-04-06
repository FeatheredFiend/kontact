<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactMenuController extends AbstractController
{
    /**
     * @Route("/contact/menu", name="contact_menu")
     */
    public function index(): Response
    {
        return $this->render('contact_menu/index.html.twig', [
            'controller_name' => 'ContactMenuController',
        ]);
    }

}
