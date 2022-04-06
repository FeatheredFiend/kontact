<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\UserRepository;
use App\Repository\DataTableRepository;
use App\Service\ActionLog;
use App\Service\Decommission;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration/show", name="registration_show")
     */
    public function show(UserRepository $userRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $q = $request->query->get('q');
        $queryBuilder = $userRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('registration/show.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/registration/create", name="registration_create")
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/registration/edit/{id}", name="registration_edit", requirements = {"id": "\d+"}, defaults={"id" = 1})
     */
    public function edit(int $id, UserRepository $userRepository, Request $request, Decommission $decommission,  ActionLog $actionLog, DataTableRepository $datatableRepository): Response
    {
        $user = $userRepository
            ->find($id);


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $userdecommissioned = $user->getDecommissioned();

            if ($userdecommissioned == 1) {
                $user = $this->getUser();
                $userid = $user->getId();
                $tablename = $datatableRepository->findBy(array('name' => 'User'),array('name' => 'ASC'),1 ,0)[0];
                $tablenameid = $tablename->getId();
                $decommission->addDecommission($userid,$tablenameid,$userid);
            }

            $user = $this->getUser();
            $userid = $user->getId();
            $userid = $user->getId();
            $tablename = $datatableRepository->findBy(array('name' => 'User'),array('name' => 'ASC'),1 ,0)[0];
            $tablenameid = $tablename->getId();
            $actionLog->addAction("Edited User",$userid,$tablenameid,$userid);

            return $this->redirectToRoute('user_show');
        }

        //return new Response('Check out this great user: '.$user->getName()
        // or render a template
        // in the template, print things with {{ user.name }}
        return $this->render('registration/edit.html.twig', ['user' => $user,'form' => $form->createView()]);

}
}