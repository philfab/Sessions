<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Module;
use App\Entity\Programme;
use App\Form\SessionType;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/sessions', name: 'sessions_list')]
    public function list(Request $request, EntityManagerInterface $entityManager, SessionRepository $sessionRepository, ModuleRepository $moduleRepository): Response
    {
        $sessions = $sessionRepository->findAll();
        $modules = $moduleRepository->findAll();
        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session, [
            'modules' => $modules
        ]);

        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {

            foreach ($session->getProgrammes() as $programme) {
                if (!$programme->getSession()) {
                    $programme->setSession($session);
                }
                $entityManager->persist($programme);
            }
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('sessions_list');
        }

        return $this->render('session/list.html.twig', [
            'sessions' => $sessions,
            'session_form' => $sessionForm->createView(),
            'modules' => $modules
        ]);
    }

    #[Route('/session/{id}', name: 'session_detail')]
    public function detail(Session $session): Response
    {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
