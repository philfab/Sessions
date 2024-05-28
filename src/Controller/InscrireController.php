<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscrireController extends AbstractController
{
    #[Route('/inscrire', name: 'app_inscrire')]
    public function index(): Response
    {
        return $this->render('inscrire/index.html.twig', [
            'controller_name' => 'InscrireController',
        ]);
    }
}
