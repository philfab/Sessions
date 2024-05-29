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

    #[Route('/stagiaire/new', name: 'stagiaire_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('stagiaires_list');
        }

        return $this->render('stagiaire/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

