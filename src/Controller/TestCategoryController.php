<?php

namespace App\Controller;

use App\Entity\TestCategory;
use App\Form\TestCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\TestCategoryRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class TestCategoryController extends AbstractController
{

    /**
     * @Route("/testcategory/show", name="testcategory_show")
     */
    public function show(TestCategoryRepository $testcategoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $testcategoryRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('test_category/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/testcategory/create", name="testcategory_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testcategory = new TestCategory();

        $form = $this->createForm(TestCategoryType::class, $testcategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testcategory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testcategoryid = $testcategory->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Test Category'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Test Category",$userid,$tablenameid,$testcategoryid);


            return $this->redirectToRoute('testcategory_show');
        }
        return $this->render('test_category/add.html.twig', ['form' => $form->createView(),'testcategory' => $testcategory]);

    }

    /**
     * @Route("/testcategory/edit/{id}", name="testcategory_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, TestCategoryRepository $testcategoryRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $testcategory = $testcategoryRepository
            ->find($id);


        $form = $this->createForm(TestCategoryType::class, $testcategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($testcategory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $testcategoryid = $testcategory->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Test Category'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Test Category",$userid,$tablenameid,$testcategoryid);

            return $this->redirectToRoute('testcategory_show');
        }

        //return new Response('Check out this great testcategory: '.$testcategory->getName()
        // or render a template
        // in the template, print things with {{ testcategory.name }}
        return $this->render('test_category/edit.html.twig', ['testcategory' => $testcategory,'form' => $form->createView()]);

}
}
