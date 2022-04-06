<?php

namespace App\Controller;

use App\Entity\Disease;
use App\Form\DiseaseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\DiseaseRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class DiseaseController extends AbstractController
{

    /**
     * @Route("/disease/show", name="disease_show")
     */
    public function show(DiseaseRepository $diseaseRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $diseaseRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('disease/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/disease/create", name="disease_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $disease = new Disease();

        $form = $this->createForm(DiseaseType::class, $disease);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($disease);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $diseaseid = $disease->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Disease'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Disease",$userid,$tablenameid,$diseaseid);


            return $this->redirectToRoute('disease_show');
        }
        return $this->render('disease/add.html.twig', ['form' => $form->createView(),'disease' => $disease]);

    }

    /**
     * @Route("/disease/edit/{id}", name="disease_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, DiseaseRepository $diseaseRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $disease = $diseaseRepository
            ->find($id);


        $form = $this->createForm(DiseaseType::class, $disease);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($disease);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $diseaseid = $disease->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Disease'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Disease",$userid,$tablenameid,$diseaseid);

            return $this->redirectToRoute('disease_show');
        }

        //return new Response('Check out this great disease: '.$disease->getName()
        // or render a template
        // in the template, print things with {{ disease.name }}
        return $this->render('disease/edit.html.twig', ['disease' => $disease,'form' => $form->createView()]);

}
}
