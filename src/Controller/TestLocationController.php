<?php

namespace App\Controller;

use App\Entity\TestLocation;
use App\Form\TestLocationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\TestLocationRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class TestLocationController extends AbstractController
{

    /**
     * @Route("/testlocation/show", name="testlocation_show")
     */
    public function show(TestLocationRepository $testlocationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $testlocationRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('test_location/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/testlocation/create", name="testlocation_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testlocation = new TestLocation();

        $form = $this->createForm(TestLocationType::class, $testlocation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testlocation);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testlocationid = $testlocation->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Test Location'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Test Location",$userid,$tablenameid,$testlocationid);


            return $this->redirectToRoute('testlocation_show');
        }
        return $this->render('test_location/add.html.twig', ['form' => $form->createView(),'testlocation' => $testlocation]);

    }

    /**
     * @Route("/testlocation/edit/{id}", name="testlocation_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, TestLocationRepository $testlocationRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testlocation = $testlocationRepository
            ->find($id);


        $form = $this->createForm(TestLocationType::class, $testlocation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testlocation);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testlocationid = $testlocation->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Test Location'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Test Location",$userid,$tablenameid,$testlocationid);

            return $this->redirectToRoute('testlocation_show');
        }

        //return new Response('Check out this great testlocation: '.$testlocation->getName()
        // or render a template
        // in the template, print things with {{ testlocation.name }}
        return $this->render('test_location/edit.html.twig', ['testlocation' => $testlocation,'form' => $form->createView()]);

}
}
