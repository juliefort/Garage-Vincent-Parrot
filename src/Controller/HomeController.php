<?php
namespace App\Controller;

use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ScheduleRepository $scheduleRepo) : Response
    {
	    return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'schedule' => $scheduleRepo->findAll() 
        ]);
    }
}