<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('days', 'Jour'),
            TextField::new('opening_hour', 'Heures'),
        ];
    }

    public function configureCrud(Crud $crud): crud 
    {
        return $crud

        ->renderContentMaximized()
        ->setPaginatorPageSize(7)

        ->setPageTitle('index', 'Horaires d\'ouverture');
    }
    
}
