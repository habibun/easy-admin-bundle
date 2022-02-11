<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
        ->hideOnForm();
        yield EmailField::new('email');
        yield BooleanField::new('enabled')
        ->renderAsSwitch(false);

        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        yield ChoiceField::new('roles')
        ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges()
        ;
        yield ImageField::new('avatar')
            ->setBasePath('upload/user/avatar')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setUploadDir('public/upload/user/avatar')
        ;
    }
}
