<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->update(Crud::PAGE_INDEX, Action::DELETE,
        fn (Action $action) => $action->setLabel('Supprimer'))
        ->remove(Crud::PAGE_INDEX, Action::EDIT);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('lastName', 'Nom de famille'),
            yield TextField::new('firstName', 'Prénom'),
            yield EmailField::new('email'),
            yield TextField::new('phoneNumber', 'Numéro de téléphone'),
            yield TextField::new('subject', 'Sujet'),
            yield TextEditorField::new('content', 'Message'),
            yield BooleanField::new('processed', 'Traité'),
        ];
    }

    public function configureCrud(Crud $crud): Crud 
    {
        return $crud

        ->renderContentMaximized()
        ->setPaginatorPageSize(10)
        ->setPageTitle('index', 'Demandes de contact');
    }
    
}
