<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\AddressRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;

class AddressController extends AbstractController
{

    /**
     * @Route("/address/show", name="address_show")
     */
    public function show(AddressRepository $addressRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $q = $request->query->get('q');
        $queryBuilder = $addressRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('address/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/address/create", name="address_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $addressid = $address->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Address'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Address",$userid,$tablenameid,$addressid);


            return $this->redirectToRoute('address_show');
        }
        return $this->render('address/add.html.twig', ['form' => $form->createView(),'address' => $address]);

    }

    /**
     * @Route("/address/edit/{id}", name="address_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, AddressRepository $addressRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $address = $addressRepository
            ->find($id);


        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $addressid = $address->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Address'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Address",$userid,$tablenameid,$addressid);

            return $this->redirectToRoute('address_show');
        }

        //return new Response('Check out this great address: '.$address->getName()
        // or render a template
        // in the template, print things with {{ address.name }}
        return $this->render('address/edit.html.twig', ['address' => $address,'form' => $form->createView()]);

}
}
