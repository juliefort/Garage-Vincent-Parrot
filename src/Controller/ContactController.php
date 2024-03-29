<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ScheduleRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager
                        , MailerInterface $mailer, ScheduleRepository $scheduleRepo,
                        CarRepository $carRepo): Response
    {
        
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        // Vérification si le formulaire a été soumis et si il est valide
        if($form->isSubmitted() && $form->isValid()) { 
            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush(); // Mise à jour vers la base de données

            return $this->redirectToRoute('app_contact_success');

        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->CreateView(),
            'schedule' => $scheduleRepo->findAll(),
            'car' => $carRepo->findBy([],[])
        ]);
    }      

    #[Route('/success', name: 'app_contact_success', methods: 'GET')]
     public function successMessage(ScheduleRepository $scheduleRepo)
     {
        return $this->render('contact/success.html.twig', [
            'schedule' => $scheduleRepo->findAll()
        ]);
     }
}

