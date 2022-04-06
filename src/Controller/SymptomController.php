<?php

namespace App\Controller;

use App\Entity\Symptom;
use App\Form\SymptomType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\SymptomRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class SymptomController extends AbstractController
{

    /**
     * @Route("/symptom/show", name="symptom_show")
     */
    public function show(SymptomRepository $symptomRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $symptomRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('symptom/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/symptom/create", name="symptom_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $symptom = new Symptom();

        $form = $this->createForm(SymptomType::class, $symptom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($symptom);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $symptomid = $symptom->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Symptom'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Symptom",$userid,$tablenameid,$symptomid);


            return $this->redirectToRoute('symptom_show');
        }
        return $this->render('symptom/add.html.twig', ['form' => $form->createView(),'symptom' => $symptom]);

    }

    /**
     * @Route("/symptom/edit/{id}", name="symptom_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, SymptomRepository $symptomRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $symptom = $symptomRepository
            ->find($id);


        $form = $this->createForm(SymptomType::class, $symptom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($symptom);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $symptomid = $symptom->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Symptom'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Symptom",$userid,$tablenameid,$symptomid);

            return $this->redirectToRoute('symptom_show');
        }

        //return new Response('Check out this great symptom: '.$symptom->getName()
        // or render a template
        // in the template, print things with {{ symptom.name }}
        return $this->render('symptom/edit.html.twig', ['symptom' => $symptom,'form' => $form->createView()]);

}
}
