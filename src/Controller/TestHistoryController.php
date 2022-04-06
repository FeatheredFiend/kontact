<?php

namespace App\Controller;

use App\Entity\TestHistory;
use App\Form\TestHistoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\TestHistoryRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class TestHistoryController extends AbstractController
{

    /**
     * @Route("/testhistory/show", name="testhistory_show")
     */
    public function show(TestHistoryRepository $testhistoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $testhistoryRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('test_history/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/testhistory/create", name="testhistory_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testhistory = new TestHistory();

        $form = $this->createForm(TestHistoryType::class, $testhistory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testhistory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testhistoryid = $testhistory->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Test History'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Test History",$userid,$tablenameid,$testhistoryid);


            return $this->redirectToRoute('testresult_create', array('id' => $testhistoryid,));
        }
        return $this->render('test_history/add.html.twig', ['form' => $form->createView(),'testhistory' => $testhistory]);

    }

    /**
     * @Route("/testhistory/edit/{id}", name="testhistory_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, TestHistoryRepository $testhistoryRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testhistory = $testhistoryRepository
            ->find($id);


        $form = $this->createForm(TestHistoryType::class, $testhistory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testhistory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testhistoryid = $testhistory->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Test History'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Test History",$userid,$tablenameid,$testhistoryid);

            return $this->redirectToRoute('testhistory_show');
        }

        //return new Response('Check out this great testhistory: '.$testhistory->getName()
        // or render a template
        // in the template, print things with {{ testhistory.name }}
        return $this->render('test_history/edit.html.twig', ['testhistory' => $testhistory,'form' => $form->createView()]);

}
}
