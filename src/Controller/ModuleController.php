<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }

    #[Route('/modules', name: 'modules_list')]
    public function list(Request $request, EntityManagerInterface $entityManager,ModuleRepository $moduleRepository): Response
    {
        $modules= $moduleRepository->findAll();
    
        $module = new Module();
        $moduleForm = $this->createForm(ModuleType::class, $module);
        
        $moduleForm->handleRequest($request);

        if ($moduleForm->isSubmitted() && $moduleForm->isValid()) {
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('modules_list');
        }

        return $this->render('module/list.html.twig', [
            'modules' => $modules,
            'module_form' => $moduleForm->createView(),
        ]);
    }
}
