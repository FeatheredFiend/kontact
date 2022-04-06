<?php

namespace App\Controller;

use App\Entity\TestResult;
use App\Form\TestResultType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Repository\TestResultRepository;
use App\Repository\TestHistoryRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;
use App\Service\AddInfection;

class TestResultController extends AbstractController
{

    /**
     * @Route("/testresult/show", name="testresult_show")
     */
    public function show(TestResultRepository $testresultRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $testresultRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('test_result/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/testresult/create/{id}", name="testresult_create", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function create(int $id, ValidatorInterface $validator,TestHistoryRepository $testhistoryRepository, TestResultRepository $testresultRepository, Request $request, AddInfection $addInfection, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testresult = new TestResult();

        $form = $this->createForm(TestResultType::class, $testresult);

        $idHistory = $testhistoryRepository->find($id);
        $date = $idHistory->getTestdate();
        $client = $idHistory->getClient();
        $client = $client->getId();

        $form->get('testhistory')->setData($idHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testresult);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testresultid = $testresult->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Test Result'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Test Result",$userid,$tablenameid,$testresultid);

            $disease = $testresult->getDisease();
            $disease = $disease->getId();

            if ($testresult->getRecordedvalue() != 0) {
                $addInfection->addInfection($client, $disease, $idHistory, date("Y-m-d"));
            }
            return $this->redirectToRoute('testresult_show');
        }
        return $this->render('test_result/add.html.twig', ['form' => $form->createView(),'testresult' => $testresult]);

    }

    /**
     * @Route("/testresult/edit/{id}", name="testresult_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, TestResultRepository $testresultRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testresult = $testresultRepository
            ->find($id);


        $form = $this->createForm(TestResultType::class, $testresult);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testresult);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testresultid = $testresult->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Test Result'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Test Result",$userid,$tablenameid,$testresultid);

            return $this->redirectToRoute('testresult_show');
        }

        //return new Response('Check out this great testresult: '.$testresult->getName()
        // or render a template
        // in the template, print things with {{ testresult.name }}
        return $this->render('test_result/edit.html.twig', ['testresult' => $testresult,'form' => $form->createView()]);

}
}
