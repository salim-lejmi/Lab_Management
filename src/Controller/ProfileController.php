<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'user_profile')]
    public function index(): Response
    {
        return $this->render('profile/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    #[Route('/profile/delete', name: 'user_delete')]
    public function deleteAccount(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, SessionInterface $session): Response
    {
        $user = $this->getUser();
        if($user && $this->isCsrfTokenValid('delete_account', $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            
            // Invalidate the current user session
            $tokenStorage->setToken(null);
            $session->invalidate();
    
            // Redirect to app_accueil
            return $this->redirectToRoute('app_accueil');
        }
        return $this->redirectToRoute('user_profile');
    }
}
