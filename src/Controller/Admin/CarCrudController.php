<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;


class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW,
        fn (Action $action) => $action->setLabel('Ajouter une voiture'))
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
        fn (Action $action) => $action->setLabel('Ajouter'))
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
        fn (Action $action) => $action->setLabel('Sauvegarder'))
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
        fn (Action $action) => $action->setLabel('Sauvegarder et continuer'))
        ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('CarName', 'Modèle de voiture'),
            yield MoneyField::new('Price', 'Prix')->setCurrency('EUR'),
            yield DateField::new('Year', 'Année de mise en circulation'),
            yield TextField::new('Kilometers', 'Kilométrage'),
            yield TextField::new('Manufacturer', 'Fabricant'),
            yield TextEditorField::new('Characteristic', 'Description des caractéristiques'),
            yield TextField::new('Image', 'Lien de l\'image'),
        ];
    }

    public function configureCrud(Crud $crud): crud 
    {
        return $crud

        ->renderContentMaximized()
        ->setPaginatorPageSize(10)

        ->setEntityLabelInPlural('Voitures')
        ->setEntityLabelInSingular('Voiture')

        ->setPageTitle('new', 'Ajouter une annonce')
        ->setPageTitle('edit', 'Modifier une annonce');
    }
    
}
