<?php

namespace App\Controller\Admin;

use App\EasyAdmin\EnabledField;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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
     * @inheritDoc
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
        return parent::configureActions($actions)
            ->setPermission(Action::INDEX, 'ROLE_MODERATOR');
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $entityInstance->setUpdatedBy($this->security->getUser());
        parent::updateEntity($entityManager, $entityInstance);
    }

}
