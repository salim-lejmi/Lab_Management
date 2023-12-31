<?php
namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PublicationController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    #[Route('/publications', name: 'publications')]
    public function index(): Response
    {
        $publications = $this->doctrine->getRepository(Publication::class)->findAll();

        return $this->render('publications/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/publications/new', name: 'new_publication')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setAuthor($this->getUser());
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publications');
        }

        return $this->render('publications/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/publications/{id}/edit', name: 'edit_publication')]
public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
{
    if ($this->getUser() !== $publication->getAuthor()) {
        throw $this->createAccessDeniedException('You cannot edit publications that you do not own.');
    }

    $form = $this->createForm(PublicationType::class, $publication);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('publications');
    }

    return $this->render('publications/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/publications/{id}/delete', name: 'delete_publication')]
    public function delete(Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($publication);
        $entityManager->flush();

        return $this->redirectToRoute('publications');
    }
    
#[Route('/publications/search', name: 'search_publications')]
public function search(Request $request): Response
{
   $query = $request->query->get('q');
   $publications = $this->doctrine->getRepository(Publication::class)->search($query);

   return $this->render('publications/search.html.twig', [
       'publications' => $publications,
       'query' => $query,
   ]);
}
}
