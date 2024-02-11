<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    
    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW,
        fn (Action $action) => $action->setLabel('Ajouter'))
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
        fn (Action $action) => $action->setLabel('Sauvegarder et continuer'))
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
        fn (Action $action) => $action->setLabel('Sauvegarder'))
        ->update(Crud::PAGE_INDEX, Action::EDIT,
        fn (Action $action) => $action->setLabel('Modifier'))
        ->update(Crud::PAGE_INDEX, Action::DELETE,
        fn (Action $action) => $action->setLabel('Supprimer'));
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
