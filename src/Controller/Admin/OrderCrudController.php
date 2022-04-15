<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();
//        yield FormField::addPanel('Details');
        yield FormField::addTab('Basic Data')
            ->collapsible();
        yield AssociationField::new('location')
            ->autocomplete()
            ->formatValue(static function ($value, Order $order) {
                return sprintf('%d-%s', $order->getLocation()->getId(), $order->getLocation()->getName());
            })
            ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                $queryBuilder->andWhere('entity.enabled = :enabled')
                    ->setParameter('enabled', true);
            })->setColumns(5);;
        yield AssociationField::new('products')
            ->autocomplete()
//            ->setFormTypeOption('choice_label', 'original.name')
//        ->setFormTypeOption('by_reference', false)
            ->setColumns(5);
        ;
//        yield FormField::addPanel('Basic Data');
        yield FormField::addTab('Details')
            ->setIcon('info')
            ->setHelp('Additional Details');
        yield Field::new('date');
        yield Field::new('totalPrice')
            ->setTextAlign('right');
    }
}
