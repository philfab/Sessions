<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(): Response
    {
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'StagiaireController',
        ]);
    }

    #[Route('/stagiaires', name: 'stagiaires_list')]
    public function list(StagiaireRepository $stagiaireRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $stagiaires = $stagiaireRepository->findAll();
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($stagiaire);
            $entityManager->flush();

            $this->addFlash('success', 'Le stagiaire a bien été inscrit');

            return $this->redirectToRoute('stagiaires_list');
        }

        return $this->render('stagiaire/list.html.twig', [
            'stagiaires' => $stagiaires,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/stagiaire/{id}', name: 'stagiaire_detail')]
    public function detail(StagiaireRepository $stagiaireRepository, int $id): Response
    {
        $stagiaire = $stagiaireRepository->find($id);

        if (!$stagiaire) {
            throw $this->createNotFoundException("Le stagiaire n'existe pas");
        }

        return $this->render('stagiaire/detail.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }

    #[Route('/stagiaire/delete/{id}', name: 'stagiaire_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, Stagiaire $stagiaire): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stagiaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stagiaire);
            $entityManager->flush();
            $this->addFlash('success', 'Le stagiaire a été supprimé avec succès');
        } else {
            $this->addFlash('error', 'Token CSRF invalide');
        }

        return $this->redirectToRoute('stagiaires_list');
    }
}
