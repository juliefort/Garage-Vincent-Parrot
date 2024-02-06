<?php

namespace App\Controller\Admin;

use App\Entity\Services;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ServicesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Services::class;
    }

    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
        fn (Action $action) => $action->setLabel('Ajouter'))
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
        fn (Action $action) => $action->setLabel('Sauvegarder'))
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
        fn (Action $action) => $action->setLabel('Sauvegarder et continuer'))
        ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
        ->update(Crud::PAGE_DETAIL, Action::DELETE,
        fn (Action $action) => $action->setLabel('Supprimer'))
        ->update(Crud::PAGE_DETAIL, Action::INDEX,
        fn (Action $action) => $action->setLabel('Retour à la liste'))
        ->update(Crud::PAGE_DETAIL, Action::EDIT,
        fn (Action $action) => $action->setLabel('Modifier'));

    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('title', 'Titre'),
            yield TextAreaField::new('content', 'Description'),
            yield TextField::new('imageFile')
                ->setFormType(VichImageType::class)->onlyWhenCreating(),
            yield ImageField::new('imageName' , ' Ajouter une image')
                ->setUploadDir('/public/uploads/images/')->onlyonIndex(),
        ];
    }
    
    public function configureCrud(Crud $crud): crud 
    {
        return $crud

        ->renderContentMaximized()
        ->setPaginatorPageSize(10)

        ->setPageTitle('new', 'Ajouter un Service');
    }
}
