<?php

namespace App\Controller;

use App\Entity\Inscrire;
use App\Entity\Session;
use App\Form\SessionType;
use App\Entity\Programme;
use App\Form\InscrireType;
use App\Form\ProgrammeType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SessionController extends AbstractController
{
    #[Route('/sessions', name: 'sessions_list')]
    public function list(Request $request, EntityManagerInterface $entityManager, SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();
        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {

            $existingSession = $entityManager->getRepository(Session::class)->findOneBy([
                'intitule' => $session->getIntitule()
            ]);

            if ($existingSession) {
                $this->addFlash('error', 'La session est déjà inscrite.');
            } else {
                $entityManager->persist($session);
                $entityManager->flush();
                $this->addFlash('success', 'La session a bien été inscrite.');
            }
            return $this->redirectToRoute('sessions_list');
        }

        return $this->render('session/list.html.twig', [
            'sessions' => $sessions,
            'session_form' => $sessionForm->createView(),
        ]);
    }

    #[Route('/session/{id}', name: 'session_detail')]
    public function detail(Session $session, Request $request, EntityManagerInterface $entityManager): Response
    {
        $inscription = new Inscrire();
        $inscription->setSession($session); // Associe la session ici
        $inscription_form = $this->createForm(InscrireType::class, $inscription);
        $inscription_form->handleRequest($request);

        $programme = new Programme();
        $programme->setSession($session);
        $programme_form = $this->createForm(ProgrammeType::class, $programme);
        $programme_form->handleRequest($request);

        if ($inscription_form->isSubmitted() && $inscription_form->isValid()) {

            $existingInscription = $entityManager->getRepository(Inscrire::class)->findOneBy([
                'session' => $session,
                'stagiaire' => $inscription->getStagiaire()
            ]);

            if ($existingInscription) {
                $this->addFlash('error', 'Le stagiaire est déjà inscrit à cette session.');
            } else {
                $entityManager->persist($inscription);
                $entityManager->flush();
                $this->addFlash('success', 'Le stagiaire a été inscrit à cette session.');
            }

            return $this->redirectToRoute('session_detail', ['id' => $session->getId()]);
        }

        if ($programme_form->isSubmitted() && $programme_form->isValid()) {

            $existingProgramme = $entityManager->getRepository(Programme::class)->findOneBy([
                'session' => $session,
                'module' => $programme->getModule()
            ]);

            if ($existingProgramme) {
                $this->addFlash('error', 'Le programme est déjà inscrit à cette session.');
            } else {
                $entityManager->persist($programme);
                $entityManager->flush();
                $this->addFlash('success', 'Le programme a été inscrit à cette session.');
            }

            return $this->redirectToRoute('session_detail', ['id' => $session->getId()]);
        }

        // Calcul du nombre de places restantes
        $placesRestantes = $session->getNbPlacesTotales() - count($session->getInscriptions());

        return $this->render('session/detail.html.twig', [
            'session' => $session,
            'inscription_form' => $inscription_form->createView(),
            'programme_form' => $programme_form->createView(),
            'places_restantes' => $placesRestantes
        ]);
    }

    #[Route('/session/delete/{id}', name: 'session_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
            $this->addFlash('success', 'La session a été supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('sessions_list');
    }
    #[Route('/inscription/delete/{id}', name: 'inscription_delete', methods: ['POST'])]
    public function deleteInscription(Request $request, Inscrire $inscription, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $inscription->getSession()->getId();

        if ($this->isCsrfTokenValid('delete' . $inscription->getStagiaire()->getId(), $request->request->get('_token'))) {
            $entityManager->remove($inscription);
            $entityManager->flush();
            $this->addFlash('success', 'Le stagiaire a été désinscrit de la session.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('session_detail', ['id' => $sessionId]);
    }

    #[Route('/programme/delete/{id}', name: 'programme_delete', methods: ['POST'])]
    public function deleteProgramme(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $programme->getSession()->getId();
        
        if ($this->isCsrfTokenValid('delete' . $programme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($programme);
            $entityManager->flush();
            $this->addFlash('success', 'Le programme a été supprimé de la session.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('session_detail', ['id' => $sessionId]);
    }
}
