<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Orm\EntityRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\CssSelector\Parser\Handler\HashHandler;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;


class UserCrudController extends AbstractCrudController
{
    public function __construct(public UserPasswordHasherInterface $userPasswordHasher) 
    {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW,
        fn (Action $action) => $action->setLabel('Supprimer'))
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
        fn (Action $action) => $action->setLabel('Ajouter'))
        ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN);

    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;

        // Hashage du mot de passe
        $hashedPassword = $this->userPasswordHasher->hashPassword
        (
           $entityInstance,
           $entityInstance->getPassword()
        );
        
        // Enregistre le mot de passe hashé dans l'entité User
        $entityInstance->setPassword($hashedPassword); 

        // Récupération des rôles
        $roles = $entityInstance->getRoles();

        // Enregistre les rôles dans l'entité User
        $entityInstance->setRoles($roles);

         parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield IdField::new('id')
                ->hideOnForm(),
            yield TextField::new('lastName', 'Nom de famille')
                ->hideOnIndex()
                ->setRequired(true),
            yield TextField::new('firstName', 'Prénom')
                ->hideOnIndex(),
            yield EmailField::new('email'),

            yield TextField::new('password', 'Mot de passe')
                ->hideOnIndex(),
            
            yield ChoiceField::new('roles', 'Rôles à définir')
                ->setChoices([
                    'Rôle Administrateur ' => 'ROLE_ADMIN',
                    'Rôle Utilisateur' => 'ROLE_USER'
                    ])
                ->allowMultipleChoices()

        ];
    }

    public function configureCrud(Crud $crud): Crud 
    {
        return $crud

        ->renderContentMaximized()
        ->setPaginatorPageSize(10)

        ->setEntityLabelInPlural('Utilisateurs')
        ->setEntityLabelInSingular('Utilisateur')
        
        ->setPageTitle('new', 'Ajouter un utilisateur');
    }
    
}
