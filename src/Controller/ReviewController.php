<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ReviewController extends AbstractController
{

    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/review', name: 'app_review', methods: ['GET','POST'])]
    public function index(
        Request $request, EntityManagerInterface $entityManager,
        ScheduleRepository $scheduleRepo): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) { 
            $review = $form->getData();

            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_success');
        }

        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
            'schedule' => $scheduleRepo->findAll(),
            'form' => $form,
        ]);
    }
}
