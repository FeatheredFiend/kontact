<?php

namespace App\Controller;

use App\Entity\DiseaseSymptom;
use App\Form\DiseaseSymptomType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\DiseaseSymptomRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class DiseaseSymptomController extends AbstractController
{

    /**
     * @Route("/diseasesymptom/show", name="diseasesymptom_show")
     */
    public function show(DiseaseSymptomRepository $diseasesymptomRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $diseasesymptomRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('disease_symptom/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/diseasesymptom/create", name="diseasesymptom_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $diseasesymptom = new DiseaseSymptom();

        $form = $this->createForm(DiseaseSymptomType::class, $diseasesymptom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($diseasesymptom);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $diseasesymptomid = $diseasesymptom->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Disease Symptom'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Disease Symptom",$userid,$tablenameid,$diseasesymptomid);


            return $this->redirectToRoute('diseasesymptom_show');
        }
        return $this->render('disease_symptom/add.html.twig', ['form' => $form->createView(),'diseasesymptom' => $diseasesymptom]);

    }

    /**
     * @Route("/diseasesymptom/edit/{id}", name="diseasesymptom_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, DiseaseSymptomRepository $diseasesymptomRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $diseasesymptom = $diseasesymptomRepository
            ->find($id);


        $form = $this->createForm(DiseaseSymptomType::class, $diseasesymptom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($diseasesymptom);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $diseasesymptomid = $diseasesymptom->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Disease Symptom'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Disease Symptom",$userid,$tablenameid,$diseasesymptomid);

            return $this->redirectToRoute('diseasesymptom_show');
        }

        //return new Response('Check out this great diseasesymptom: '.$diseasesymptom->getName()
        // or render a template
        // in the template, print things with {{ diseasesymptom.name }}
        return $this->render('disease_symptom/edit.html.twig', ['diseasesymptom' => $diseasesymptom,'form' => $form->createView()]);

}
}
