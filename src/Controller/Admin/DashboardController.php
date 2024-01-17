<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Review;
use App\Entity\Services;
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
            ->setTitle('Garage Vincent Parrot - Espace Administrateur')
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
                    MenuItem::linkToCrud('Modifier un service', 'fa fa-plus', Services::class)->setAction(Crud::PAGE_EDIT),
                    MenuItem::linkToCrud('Supprimer un service', 'fa fa-trash', Services::class)->setAction(Crud::PAGE_DETAIL)
            ]);
        }
          
        if($this->isGranted('ROLE_ADMIN')) 
        {
            //   yield MenuItem::linkToCrud('Modifier les horaires', 'fa fa-calendar', OpeningHours::class)->setAction(Crud::PAGE_EDIT);

        }
          
        yield MenuItem::subMenu('Annonce', 'fa fa-car')->setSubItems([
              MenuItem::linkToCrud('Créer une annonce', 'fa fa-car', Car::class)->setAction(Crud::PAGE_NEW),
              MenuItem::linkToCrud('Modifier une annonce', 'fa fa-car', Car::class)->setAction(Crud::PAGE_EDIT),
              MenuItem::linkToCrud('Aperçu des annonces', 'fa fa-eye', Car::class)
        ]);

       // yield MenuItem::linkToCrud('Ajouter une image', 'fa fa-image', Image::class);

        yield MenuItem::subMenu('Témoignage', 'fa fa-comment')->setSubItems([
              MenuItem::linkToCrud('Ajouter un nouveau témoignage', 'fa fa-plus', Review::class),
              MenuItem::linkToCrud('Aperçu des témoignages', 'fa fa-eye', Review::class)
        ]);
        
       // yield MenuItem::linkToCrud('Renseignements client', 'fa fa-message', Contact::class);

         
    }
}
