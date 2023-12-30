<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResearcherController extends AbstractController
{

    #[Route('/researchers', name: 'researchers')]

    public function index(UserRepository $userRepository): Response
    {
        
        return $this->render('researcher/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
