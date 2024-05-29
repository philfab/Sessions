<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Module;
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
    public function list(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();

        return $this->render('session/list.html.twig', [
            'sessions' => $sessions,
        ]);
    }



    #[Route('/session/new', name: 'session_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, ModuleRepository $moduleRepository): Response
    {
        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);

        $module = new Module();
        $moduleForm = $this->createForm(ModuleType::class, $module);

        $sessionForm->handleRequest($request);
        $moduleForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('sessions_list');
        }

        if ($moduleForm->isSubmitted() && $moduleForm->isValid()) {
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('session_new');
        }

        $modules = $moduleRepository->findAll();

        return $this->render('session/new.html.twig', [
            'session_form' => $sessionForm->createView(),
            'module_form' => $moduleForm->createView(),
            'modules' => $modules,
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
