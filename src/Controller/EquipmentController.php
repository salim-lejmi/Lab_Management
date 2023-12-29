<?php
namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class EquipmentController extends AbstractController
{
   private $doctrine;

   public function __construct(ManagerRegistry $doctrine)
   {
       $this->doctrine = $doctrine;
   }

   #[Route('/equipments', name: 'equipments')]
   public function index(): Response
   {
       $equipments = $this->doctrine->getRepository(Equipment::class)->findAll();

       return $this->render('equipments/index.html.twig', [
           'equipments' => $equipments,
       ]);
   }

   #[Route('/equipments/new', name: 'new_equipment')]
   public function new(Request $request, EntityManagerInterface $entityManager): Response
   {
       $equipment = new Equipment();
       $form = $this->createForm(EquipmentType::class, $equipment);

       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->persist($equipment);
           $entityManager->flush();

           return $this->redirectToRoute('equipments');
       }

       return $this->render('equipments/new.html.twig', [
           'form' => $form->createView(),
       ]);
   }

   #[Route('/equipments/{id}/edit', name: 'edit_equipment')]
   public function edit(Request $request, Equipment $equipment, EntityManagerInterface $entityManager): Response
   {
       $form = $this->createForm(EquipmentType::class, $equipment);

       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->flush();

           return $this->redirectToRoute('equipments');
       }

       return $this->render('equipments/edit.html.twig', [
           'form' => $form->createView(),
       ]);
   }

   #[Route('/equipments/{id}/delete', name: 'delete_equipment')]
   public function delete(Equipment $equipment, EntityManagerInterface $entityManager): Response
   {
       $entityManager->remove($equipment);
       $entityManager->flush();

       return $this->redirectToRoute('equipments');
   }
}
