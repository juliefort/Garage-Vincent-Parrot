<?php

namespace App\Controller;

use App\Entity\Contact;

use App\Repository\ScheduleRepository;
use App\Repository\CarRepository;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/car', name: 'app_car' , methods: ['GET','POST'])]
    public function index(ScheduleRepository $scheduleRepo, CarRepository $carRepo,
    Request $request, EntityManagerInterface $entityManager
    , MailerInterface $mailer): Response
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

        return $this->render('car/index.html.twig', [
            'schedule' => $scheduleRepo->findAll(),
            'car' => $carRepo->findAll(),
            'form' => $form
        ]);
    }


    #[Route('/car/{id}', name: 'app_show', methods: ['GET','POST'] )]
    public function carDetails(Request $request, EntityManagerInterface $entityManager,
     ScheduleRepository $scheduleRepo, CarRepository $carRepo, int $id) 
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

        return $this->render('car/details.html.twig', [
            'schedule' => $scheduleRepo->findAll(),
            'car' => $carRepo->find($id),
            'form' => $form
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
