<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::DELETE,
        fn (Action $action) => $action->setLabel('Supprimer'))
        ->update(Crud::PAGE_INDEX, Action::EDIT,
        fn (Action $action) => $action->setLabel('Modifier'))
        ->remove(Crud::PAGE_INDEX, Action::NEW);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('imageName', 'Nom de la photo'),
            yield IntegerField::new('imageSize', 'Taille de la photo'),
            yield DateTimeField::new('updatedAt', 'Mis à jour')
               ->setDisabled(),
            yield AssociationField::new('car', 'Voitures')
        ];
    }
    
}
