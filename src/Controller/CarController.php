<?php

namespace App\Controller;

use App\Entity\Contact;

use App\Repository\ScheduleRepository;
use App\Repository\CarRepository;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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

        // Envoi de l'e-mail de demande de contact à l'admin sur Mailtrap

            $adminEmail = $_ENV['ADMIN_MAIL']; 

            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to($adminEmail)
            ->subject($contact->getSubject())
            ->htmlTemplate('contact/email.html.twig')
           
            // Permet d'utiliser des variables dans le template Email
            ->context([
                'contact' => $contact
            ]);

            $mailer->send($email);

            return $this->redirectToRoute('app_contact_success');
        }

        return $this->render('car/index.html.twig', [
            'schedule' => $scheduleRepo->findAll(),
            'car' => $carRepo->findBy([],[]),
            'form' => $form
        ]);
    }
}                                       
