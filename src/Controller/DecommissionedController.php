<?php

namespace App\Controller;


use App\Entity\Decommissioned;
use App\Form\DecommissionedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DecommissionedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;


class DecommissionedController extends AbstractController
{
    /**
     * @Route("/decommissioned/show", name="decommissioned_show")
     */
    public function show(DecommissionedRepository $decommissionedRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');

        $queryBuilder = $decommissionedRepository->getWithSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('decommissioned/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
