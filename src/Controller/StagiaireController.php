<?php

namespace App\Controller;

use App\Repository\StagiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function list(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires = $stagiaireRepository->findAll();

        return $this->render('stagiaire/list.html.twig', [
            'stagiaires' => $stagiaires,
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
}
