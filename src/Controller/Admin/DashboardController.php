<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Review;
use App\Entity\Services;
use App\Entity\Contact;
use App\Entity\Schedule;
use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){}

    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
        ->setController(CarCrudController::class)
        ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="./image/logo.jpg">')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');

        if($this->isGranted('ROLE_ADMIN')) 
        {

           yield MenuItem::subMenu('Utilisateur', 'fa fa-user')->setSubItems([
                 MenuItem::linkToCrud('Ajouter un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),
                 MenuItem::linkToCrud('Supprimer un utilisateur', 'fa fa-trash', User::class)
            ]);
        }
            
        if($this->isGranted('ROLE_ADMIN')) 
        {
              yield MenuItem::subMenu('Services', 'fa fa-pen-to-square')->setSubItems([
                    MenuItem::linkToCrud('Ajouter un service', 'fa fa-plus', Services::class)->setAction(Crud::PAGE_NEW),
                    MenuItem::linkToCrud('Aperçu des services', 'fa fa-trash', Services::class)->setAction(Crud::PAGE_INDEX)
            ]);
        }
          
        if($this->isGranted('ROLE_ADMIN')) 
        {
               yield MenuItem::linkToCrud('Horaires d\'ouverture', 'fa fa-calendar', Schedule::class)->setAction(Crud::PAGE_INDEX);

        }
          
        yield MenuItem::subMenu('Annonce', 'fa fa-car')->setSubItems([
              MenuItem::linkToCrud('Créer une annonce', 'fa fa-car', Car::class)->setAction(Crud::PAGE_NEW),
              MenuItem::linkToCrud('Aperçu des annonces', 'fa fa-eye', Car::class)
        ]);

        yield MenuItem::subMenu('Témoignage', 'fa fa-comment')->setSubItems([
              MenuItem::linkToCrud('Aperçu des témoignages', 'fa fa-eye', Review::class)
        ]);
        
        yield MenuItem::linkToCrud('Demandes de contact', 'fa fa-message', Contact::class);
       
        yield MenuItem::linkToCrud('Image', 'fa fa-images', Image::class);
    }
}
