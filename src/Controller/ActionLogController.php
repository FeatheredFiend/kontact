<?php

namespace App\Controller;


use App\Entity\ActionLog;
use App\Form\ActionLogType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ActionLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;


class ActionLogController extends AbstractController
{
    /**
     * @Route("/actionlog/show", name="actionlog_show")
     */
    public function show(ActionLogRepository $actionlogRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $actionlogRepository->getWithSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('action_log/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

   
}
