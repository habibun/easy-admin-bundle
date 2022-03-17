<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $qb;
        }

        return $qb->andWhere('entity.id =:id')
            ->setParameter('id', $this->getUser()->getId())
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
        ->hideOnForm();
        yield AvatarField::new('avatar')
            ->formatValue(static function ($value, ?User $user) {
                return $user?->getAvatarUrl();
            });
        yield EmailField::new('email')
        ->setSortable(false);
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
            ->onlyOnForms()
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setDefaultSort([
                'enabled' => 'DESC',
            ])
            ->setEntityPermission('ADMIN_USER_EDIT')
            ;
    }
}
