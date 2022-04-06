<?php

namespace App\Controller;

use App\Entity\ContactHistory;
use App\Form\ContactHistoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ContactHistoryRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class ContactHistoryController extends AbstractController
{

    /**
     * @Route("/contacthistory/show", name="contacthistory_show")
     */
    public function show(ContactHistoryRepository $contacthistoryRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $contacthistoryRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        $queryBuilderLatitude = $contacthistoryRepository->getWithSearchQueryBuilderLatitude($q);

        $paginationLatitude = $paginator->paginate(
            $queryBuilderLatitude, /* query NOT result */
            //$request->query->getInt('page', 1)/*page number*/,
            //5000/*limit per page*/
        );

        $queryBuilderLongitude = $contacthistoryRepository->getWithSearchQueryBuilderLongitude($q);

        $paginationLongitude = $paginator->paginate(
            $queryBuilderLongitude, /* query NOT result */
            //$request->query->getInt('page', 1)/*page number*/,
            //5000/*limit per page*/
        );


        return $this->render('contact_history/show.html.twig', [
            'pagination' => $pagination,
            'paginationLatitude' => $paginationLatitude,
            'paginationLongitude' => $paginationLongitude,
        ]);
    }

    /**
     * @Route("/contacthistory/create", name="contacthistory_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $contacthistory = new ContactHistory();

        $form = $this->createForm(ContactHistoryType::class, $contacthistory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacthistory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $contacthistoryid = $contacthistory->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Contact History'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Contact History",$userid,$tablenameid,$contacthistoryid);


            return $this->redirectToRoute('contacthistory_show');
        }
        return $this->render('contact_history/add.html.twig', ['form' => $form->createView(),'contacthistory' => $contacthistory]);

    }

    /**
     * @Route("/contacthistory/edit/{id}", name="contacthistory_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, ContactHistoryRepository $contacthistoryRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $contacthistory = $contacthistoryRepository
            ->find($id);


        $form = $this->createForm(ContactHistoryType::class, $contacthistory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacthistory);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $contacthistoryid = $contacthistory->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Contact History'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Contact History",$userid,$tablenameid,$contacthistoryid);

            return $this->redirectToRoute('contacthistory_show');
        }

        //return new Response('Check out this great contacthistory: '.$contacthistory->getName()
        // or render a template
        // in the template, print things with {{ contacthistory.name }}
        return $this->render('contact_history/edit.html.twig', ['contacthistory' => $contacthistory,'form' => $form->createView()]);

}
}
