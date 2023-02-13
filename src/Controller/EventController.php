<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    #[Route('/', name: 'app_event')]
    public function index(Request $request, EvenementRepository $repo): Response
    {
        $event = $repo->findAll();

        // dd($request);
        $input = ($request->query->get('query'));
        dump($input);

        return $this->render('event/index.html.twig', [
            'events' => $event,
            'input' => $input
        ]);
    }
    public function name(User $user)
    {
        return $this->render('base.html.twig', [
            'user'=> $user,
        ]);
    }
}
