<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use PhpParser\Builder\Class_;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name: 'admin')]
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

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
          
        // yield MenuItem::subMenu('Annonce', 'fa fa-car')->setSubItems([
             // MenuItem::linkToCrud('Créer une annonce', 'fa fa-car', Car::class)->setAction(Crud::PAGE_NEW),
            //MenuItem::linkToCrud('Modifier une annonce', 'fa fa-car', Car::class),
            //MenuItem::linkToCrud('Aperçu des annonces', 'fa fa-eye', Car::class)
       // ]);

       // yield MenuItem::linkToCrud('Ajouter une image', 'fa fa-image', Image::class);

       // yield MenuItem::subMenu('Témoignage', 'fa fa-comment')->setSubItems([
            //  MenuItem::linkToCrud('Ajouter un nouveau témoignage', 'fa fa-plus', Review::class),
            //  MenuItem::linkToCrud('Aperçu des témoignages', 'fa fa-eye', Review::class)
       // ]);
        
       // yield MenuItem::linkToCrud('Renseignements client', 'fa fa-message', Contact::class);

        if($this->isGranted('ROLE_ADMIN')) 
        {

           yield MenuItem::subMenu('Utilisateur', 'fa fa-user')->setSubItems([
                 MenuItem::linkToCrud('Ajouter un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),
                 MenuItem::linkToCrud('Supprimer un utilisateur', 'fa fa-trash', User::class)
            ]);
        }
            
        if($this->isGranted('ROLE_ADMIN')) 
        {
            //  yield MenuItem::subMenu('Services', 'fa fa-pen-to-square')->setSubItems([
              //    MenuItem::linkToCrud('Ajouter un service', 'fa fa-plus', Services::class)->setAction(Crud::PAGE_NEW),
              //    MenuItem::linkToCrud('Modifier un services', 'fa fa-plus', Services::class)->setAction(Crud::PAGE_EDIT),
               //   MenuItem::linkToCrud('Supprimer un service', 'fa fa-trash', Services::class)
         //   ]);
        }
          
        if($this->isGranted('ROLE_ADMIN')) 
        {
            //   yield MenuItem::linkToCrud('Modifier les horaires', 'fa fa-calendar', OpeningHours::class)->setAction(Crud::PAGE_EDIT);

        }
         
    }
}
