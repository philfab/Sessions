<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/sessions', name: 'sessions_list')]
    public function list(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();

        return $this->render('session/list.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    #[Route('/session/{id}', name: 'session_detail')]
    public function detail(SessionRepository $sessionRepository, int $id): Response
    {
        $session = $sessionRepository->find($id);

        if (!$session) {
            throw $this->createNotFoundException("La session n'existe pas");
        }

        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
