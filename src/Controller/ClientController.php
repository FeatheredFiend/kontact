<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ClientRepository;
use App\Repository\AddressRepository;
use App\Repository\DataTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\ActionLog;
use App\Service\AddAddress;
use Symfony\Component\HttpFoundation\JsonResponse;


class ClientController extends AbstractController
{

    /**
     * @Route("/client/show", name="client_show")
     */
    public function show(ClientRepository $clientRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $q = $request->query->get('q');
        $queryBuilder = $clientRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('client/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/client/create", name="client_create")
     */
    public function create(ValidatorInterface $validator, Request $request, ActionLog $actionLog, AddressRepository $addressRepository, DataTableRepository $datatableRepository): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $client->getAddress();
            $user = $this->getUser();
            $userid = $user->getId();
            $clientid = $client->getId();

            $tablename = $datatableRepository->findBy(array('name' => 'Client'), array('name' => 'ASC'), 1, 0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Added Client", $userid, $tablenameid, $clientid);


            return $this->redirectToRoute('client_show');
        }
        return $this->render('client/add.html.twig', ['form' => $form->createView(),'client' => $client]);
    }

    /**
     * @Route("/client/edit/{id}", name="client_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, ClientRepository $clientRepository, Request $request, ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $client = $clientRepository
            ->find($id);


        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $user = $this->getUser();
            $userid = $user->getId();
            $clientid = $client->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'Client'), array('name' => 'ASC'), 1, 0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited Client", $userid, $tablenameid, $clientid);

            return $this->redirectToRoute('client_show');
        }

        //return new Response('Check out this great client: '.$client->getName()
        // or render a template
        // in the template, print things with {{ client.name }}
        return $this->render('client/edit.html.twig', ['client' => $client,'form' => $form->createView()]);
    }

    /**
     * @Route("/post-address", name="post-address")
     */
    public function postNewAddressAction(Request $request,AddAddress $addAddress)
    {
        $addressline1 = $_POST['address1'];
        $addressline2 = $_POST['address2'];
        $addressline3 = $_POST['address3'];
        $addressline4 = $_POST['address4'];
        $addressline5 = $_POST['address5'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $addAddress->addAddress($addressline1,$addressline2,$addressline3,$addressline4,$addressline5,$latitude,$longitude);
        $responseArray = array();
        return new JsonResponse($responseArray);
    }


    /**
     * Returns a JSON string with the addresses of the Organisation with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     * @Route("/get-address", name="get-address")
     */
    public function getNewAddressAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $addressesRepository = $em->getRepository("App:Address");
        
        // Search the addresses that belongs to the organisation with the given id as GET parameter "organisationid"
        $addresses = $addressesRepository->createQueryBuilder("q")
            ->getQuery()
            ->getResult();
        
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($addresses as $address){
            $responseArray[] = array(
                "id" => $address->getId(),
                "addressline1" => $address->getAddressline1()
            );
        }
        
        // Return array with structure of the addresses of the providen organisation id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }

}