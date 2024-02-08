<?php
namespace App\Controller;


use App\Repository\ScheduleRepository;
use App\Repository\ServicesRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        ScheduleRepository $scheduleRepo, ServicesRepository $servicesRepo,
        ReviewRepository $reviewRepo
        ) : Response
    {
	    return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'schedule' => $scheduleRepo->findAll(),
            'services' => $servicesRepo->findBy([],[]),
            'review' => $reviewRepo->findAll()
        ]);
    }
}