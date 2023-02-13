<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EventFormType;
use App\Form\JoinType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventFormController extends AbstractController
{
    #[Route('/form', name: 'app_event_form')]
    public function index(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        
        $product = new Evenement();
        $form = $this->createForm(EventFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $user->getUsername();


            $entityManager = $doctrine->getManager();

            $product->setUserId($user);
            $product->setAttendant(0);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('app_event');
        };

        return $this->render('event_form/index.html.twig', [
            'event_form' => $form->createView(),
        ]);
    }
    #[Route("/event/edit/{id}", name: "edit_article")]
    public function edit(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Evenement $event): Response
    {
        $test = $event->getAttendant()+1;
        $id = $request->get('id');
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(EventFormType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $evenement->setAttendant($test);
            
            $em = $this->getDoctrine()->getManager();
            $categoryData = $form->getData();
            $em->persist($categoryData);
            $em->flush();
            return $this->redirectToRoute('app_event');
        }

        return $this->render('event_form/index.html.twig', [
            'event_form' => $form->createView(),
        ]);
    }
    #[Route("/event/join/{id}", name: "join_article")]
    public function join(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Evenement $event, EvenementRepository $repo): Response
    {
        $test = $event->getAttendant()+1;
        
        $id = $request->get('id');
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(JoinType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $users = $this->get('security.token_storage')->getToken()->getUser();
            $users->getUsername();

            $evenement->setAttendant($test);
            $evenement->addAttendantId($users);

            $em = $this->getDoctrine()->getManager();
            $categoryData = $form->getData();
            $em->persist($categoryData);
            $em->flush();
            return $this->redirectToRoute('app_event');
        }

        return $this->render('event_form/join.html.twig', [
            'event' => $event,
            'event_form' => $form->createView(),
        ]);
    }
    public function name(User $user)
    {
        return $this->render('event_form/join.html.twig', [
            'user'=> $user,
        ]);
    }
}
