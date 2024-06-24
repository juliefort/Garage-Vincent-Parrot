<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use App\Form\CarImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

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
        ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
        ->update(Crud::PAGE_INDEX, Action::DELETE,
        fn (Action $action) => $action->setLabel('Supprimer'))
        ->update(Crud::PAGE_INDEX, Action::EDIT,
        fn (Action $action) => $action->setLabel('Modifier'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('carName', 'Modèle de voiture'),
            yield IntegerField::new('price', 'Prix'),
            yield TextField::new('year', 'Année de mise en circulation'),
            yield IntegerField::new('kilometers', 'Kilométrage'),
            yield TextField::new('manufacturer', 'Fabricant'),
            yield ChoiceField::new('fuel', 'Carburant')->setChoices([
                'Électrique' => 'Électrique',
                'Gazole' => 'Gazole',
                'Essence' => 'Essence',
                'Superéthanol' => 'Superéthanol',
                'SP98' => 'SP98',
                'Diesel' => 'Diesel',
            ]),
            yield TextAreaField::new('characteristic', 'Description des caractéristiques'),
            yield CollectionField::new('image')
                ->setEntryType(CarImageType::class),
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
