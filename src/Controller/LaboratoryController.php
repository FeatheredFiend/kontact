<?php

namespace App\Controller;

use App\Entity\Laboratory;
use App\Form\LaboratoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\LaboratoryRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class LaboratoryController extends AbstractController
{

    /**
     * @Route("/laboratory/show", name="laboratory_show")
     */
    public function show(LaboratoryRepository $laboratoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $laboratoryRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('laboratory/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/laboratory/create", name="laboratory_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $laboratory = new Laboratory();

        $form = $this->createForm(LaboratoryType::class, $laboratory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($laboratory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $laboratoryid = $laboratory->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Laboratory'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Laboratory",$userid,$tablenameid,$laboratoryid);


            return $this->redirectToRoute('laboratory_show');
        }
        return $this->render('laboratory/add.html.twig', ['form' => $form->createView(),'laboratory' => $laboratory]);

    }

    /**
     * @Route("/laboratory/edit/{id}", name="laboratory_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, LaboratoryRepository $laboratoryRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $laboratory = $laboratoryRepository
            ->find($id);


        $form = $this->createForm(LaboratoryType::class, $laboratory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($laboratory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $laboratoryid = $laboratory->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Laboratory'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Laboratory",$userid,$tablenameid,$laboratoryid);

            return $this->redirectToRoute('laboratory_show');
        }

        //return new Response('Check out this great laboratory: '.$laboratory->getName()
        // or render a template
        // in the template, print things with {{ laboratory.name }}
        return $this->render('laboratory/edit.html.twig', ['laboratory' => $laboratory,'form' => $form->createView()]);

}
}
