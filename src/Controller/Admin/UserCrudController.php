<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Command\UserPasswordHashCommand;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Orm\EntityRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
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
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
      
        // Hashage du mot de passe
        $hashedPassword = $this->userPasswordHasher->hashPassword
        (
           $entityInstance,
           $entityInstance->getPassword()
        );
        

        // Stockage du mot de passe dans l'entité 
        $entityInstance->setPassword($hashedPassword); 

        $entityManager->persist($entityInstance);
        $entityManager->flush();
       
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('LastName', 'Nom de famille')
                ->hideOnIndex(),
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
        ->setEntityLabelInSingular('Utilisateur');
        
    }
    
}
