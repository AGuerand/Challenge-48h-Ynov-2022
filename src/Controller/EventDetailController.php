<?php

namespace App\Controller;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CommentaireFormType;
use App\Entity\Evenement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class EventDetailController extends AbstractController
{   
    #[Route('/event/detail/{id}', name: 'app_event_detail')]
    public function details(Evenement $event, Request $request, EntityManagerInterface $manager, Commentaire $commentaire=null)
    { 
        $user = $this->getUser();
        $commentaire = new Commentaire;
        $commentaire->setUserId($user);
        $commentaire->setEventId($event);
        $commentaire->setCreatedAt(new \DateTime());

        $form = $this->createForm(CommentaireFormType::class, $commentaire);
        $form->handleRequest($request);
        dump($form);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($commentaire);
            $manager->flush();
            return $this->redirectToRoute('app_event_detail',[
                'id' => $event->getId()
            ]
            );
        }
        return $this->render('event_detail/index.html.twig', [
            'event'=> $event,
            'formCommentaire' => $form->createView()
        ]);
    }
}
