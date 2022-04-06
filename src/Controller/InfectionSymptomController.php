<?php

namespace App\Controller;

use App\Entity\InfectionSymptom;
use App\Form\InfectionSymptomType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\InfectionSymptomRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class InfectionSymptomController extends AbstractController
{

    /**
     * @Route("/infectionsymptom/show", name="infectionsymptom_show")
     */
    public function show(InfectionSymptomRepository $infectionsymptomRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $infectionsymptomRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('infection_symptom/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/infectionsymptom/create", name="infectionsymptom_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $infectionsymptom = new InfectionSymptom();

        $form = $this->createForm(InfectionSymptomType::class, $infectionsymptom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($infectionsymptom);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $infectionsymptomid = $infectionsymptom->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Infection Symptom'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Infection Symptom",$userid,$tablenameid,$infectionsymptomid);


            return $this->redirectToRoute('infectionsymptom_show');
        }
        return $this->render('infection_symptom/add.html.twig', ['form' => $form->createView(),'infectionsymptom' => $infectionsymptom]);

    }

    /**
     * @Route("/infectionsymptom/edit/{id}", name="infectionsymptom_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, InfectionSymptomRepository $infectionsymptomRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $infectionsymptom = $infectionsymptomRepository
            ->find($id);


        $form = $this->createForm(InfectionSymptomType::class, $infectionsymptom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($infectionsymptom);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $infectionsymptomid = $infectionsymptom->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Infection Symptom'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Infection Symptom",$userid,$tablenameid,$infectionsymptomid);

            return $this->redirectToRoute('infectionsymptom_show');
        }

        //return new Response('Check out this great infectionsymptom: '.$infectionsymptom->getName()
        // or render a template
        // in the template, print things with {{ infectionsymptom.name }}
        return $this->render('infection_symptom/edit.html.twig', ['infectionsymptom' => $infectionsymptom,'form' => $form->createView()]);

}
}
