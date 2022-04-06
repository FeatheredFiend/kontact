<?php

namespace App\Controller;

use App\Entity\Infection;
use App\Form\AddInfectionType;
use App\Form\EditInfectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\InfectionRepository;
use App\Repository\TestHistoryRepository;
use App\Repository\TestResultRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class InfectionController extends AbstractController
{

    /**
     * @Route("/infection/show", name="infection_show")
     */
    public function show(InfectionRepository $infectionRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $infectionRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('infection/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/infection/create/{id}", name="infection_create", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function create(int $id, ValidatorInterface $validator, TestHistoryRepository $testhistoryRepository, TestResultRepository $testresultRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $infection = new Infection();

        $form = $this->createForm(AddInfectionType::class, $infection);

        $idHistory = $testhistoryRepository->find($id);
        $idResult = $testresultRepository->find($id);
        $date = $idHistory->getTestdate();
        $client = $idHistory->getClient();
        $disease = $idResult->getDisease();

        $form->get('client')->setData($client);
        $form->get('disease')->setData($disease);
        $form->get('infectiontest')->setData($idHistory);
        $form->get('infectiondate')->setData($date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($infection);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $infectionid = $infection->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Infection'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Infection",$userid,$tablenameid,$infectionid);


            return $this->redirectToRoute('infection_show');
        }
        return $this->render('infection/add.html.twig', ['form' => $form->createView(),'infection' => $infection]);

    }

    /**
     * @Route("/infection/edit/{id}", name="infection_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, InfectionRepository $infectionRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $infection = $infectionRepository
            ->find($id);


        $form = $this->createForm(EditInfectionType::class, $infection);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($infection);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $infectionid = $infection->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Infection'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Infection",$userid,$tablenameid,$infectionid);

            return $this->redirectToRoute('infection_show');
        }

        //return new Response('Check out this great infection: '.$infection->getName()
        // or render a template
        // in the template, print things with {{ infection.name }}
        return $this->render('infection/edit.html.twig', ['infection' => $infection,'form' => $form->createView()]);

}
}
