<?php

namespace App\Controller\Admin;

use App\EasyAdmin\EnabledField;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

#[IsGranted('ROLE_MODERATOR')]
class LocationCrudController extends AbstractCrudController
{
    private Security $security;

    /**
     * {@inheritDoc}
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            Field::new('name')->setPermission('ROLE_MODERATOR'),
            EnabledField::new('enabled'),
            TextareaField::new('description')
                ->setFormTypeOptions([
                    'row_attr' => [
                        'data-controller' => 'snarkdown',
                    ],
                    'attr' => [
                        'data-snarkdown-target' => 'input',
                        'data-action' => 'snarkdown#render',
                    ],
                ]),
            AssociationField::new('updatedBy'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewAction = Action::new('view')
            ->linkToUrl(function(Location $location) {
                return $this->generateUrl('login', [
                    'id' => $location->getId(),
                ]);
            })
            ->addCssClass('btn btn-success')
            ->setIcon('fa fa-eye')
            ->setLabel('View on site');

        return parent::configureActions($actions)
            ->update(Crud::PAGE_INDEX, Action::DELETE, static function (Action $action) {
                $action->displayIf(static function (Location $location) {
                    return $location->getEnabled();
                });

                return $action;
            })
            ->setPermission(Action::INDEX, 'ROLE_MODERATOR')
            ->add(Crud::PAGE_DETAIL, $viewAction)
            ;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedBy($this->security->getUser());
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->getIsApproved()) {
            throw new \Exception('Deleting approved questions is forbidden!');
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }
}
