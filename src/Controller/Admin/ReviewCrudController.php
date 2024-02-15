<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
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
            yield TextField::new('reviewName', 'Titre :' ),
            yield TextField::new('content', 'Message :' ),
            yield TextField::new('lastName', 'Nom :' ),
            yield IntegerField::new('rating', 'Note : ' ),
            yield BooleanField::new('approved', 'Approuvé'),
        ];
    }

    public function configureCrud(Crud $crud): crud 
    {
        return $crud

        ->renderContentMaximized()
        ->setPaginatorPageSize(10)

        ->setEntityLabelInPlural('Avis');
    }
    
}
