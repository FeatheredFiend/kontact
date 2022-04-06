<?php

namespace App\Controller;

use App\Entity\InfectedLocation;
use App\Form\InfectedLocationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\InfectedLocationRepository;
use App\Repository\ContactHistoryRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class InfectedLocationController extends AbstractController
{

    /**
     * @Route("/infectedlocation/show", name="infectedlocation_show")
     */
    public function show(InfectedLocationRepository $infectedlocationRepository, ContactHistoryRepository $contacthistoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $infectedlocationRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        $queryBuilderLatitude = $infectedlocationRepository->getWithSearchQueryBuilderLatitude($q);

        $paginationLatitude = $paginator->paginate(
            $queryBuilderLatitude, /* query NOT result */
            //$request->query->getInt('page', 1)/*page number*/,
            //5000/*limit per page*/
        );

        $queryBuilderLongitude = $infectedlocationRepository->getWithSearchQueryBuilderLongitude($q);

        $paginationLongitude = $paginator->paginate(
            $queryBuilderLongitude, /* query NOT result */
            //$request->query->getInt('page', 1)/*page number*/,
            //5000/*limit per page*/
        );

        $queryBuilderLatitudeContact = $contacthistoryRepository->getWithSearchQueryBuilderLatitude($q);

        $paginationLatitudeContact = $paginator->paginate(
            $queryBuilderLatitudeContact, /* query NOT result */
            //$request->query->getInt('page', 1)/*page number*/,
            //5000/*limit per page*/
        );

        $queryBuilderLongitudeContact = $contacthistoryRepository->getWithSearchQueryBuilderLongitude($q);

        $paginationLongitudeContact = $paginator->paginate(
            $queryBuilderLongitudeContact, /* query NOT result */
            //$request->query->getInt('page', 1)/*page number*/,
            //5000/*limit per page*/
        );

        return $this->render('infected_location/show.html.twig', [
            'pagination' => $pagination,
            'paginationLatitude' => $paginationLatitude,
            'paginationLongitude' => $paginationLongitude,
            'paginationLatitudeContact' => $paginationLatitudeContact,
            'paginationLongitudeContact' => $paginationLongitudeContact,
        ]);
    }

    /**
     * @Route("/infectedlocation/create", name="infectedlocation_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $infectedlocation = new InfectedLocation();

        $form = $this->createForm(InfectedLocationType::class, $infectedlocation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($infectedlocation);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $infectedlocationid = $infectedlocation->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Infected Location'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Infected Location",$userid,$tablenameid,$infectedlocationid);


            return $this->redirectToRoute('infectedlocation_show');
        }
        return $this->render('infected_location/add.html.twig', ['form' => $form->createView(),'infectedlocation' => $infectedlocation]);

    }

    /**
     * @Route("/infectedlocation/edit/{id}", name="infectedlocation_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, InfectedLocationRepository $infectedlocationRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $infectedlocation = $infectedlocationRepository
            ->find($id);


        $form = $this->createForm(InfectedLocationType::class, $infectedlocation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($infectedlocation);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $infectedlocationid = $infectedlocation->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Infected Location'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Infected Location",$userid,$tablenameid,$infectedlocationid);

            return $this->redirectToRoute('infected_location_show');
        }

        //return new Response('Check out this great infectedlocation: '.$infectedlocation->getName()
        // or render a template
        // in the template, print things with {{ infectedlocation.name }}
        return $this->render('infected_location/edit.html.twig', ['infectedlocation' => $infectedlocation,'form' => $form->createView()]);

}
}
