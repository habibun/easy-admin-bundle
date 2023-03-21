<?php

namespace App\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use function Symfony\Component\String\u;

class TruncateLongTextConfiguration implements FieldConfiguratorInterface
{
    public const MAX_LENGTH = 25;

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return TextareaField::class === $field->getFieldFqcn();
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        $crud = $context->getCrud();

        if (Crud::PAGE_DETAIL === $crud->getCurrentPage()) {
            return;
        }

        if (strlen($field->getFormattedValue() < self::MAX_LENGTH)) {
            return;
        }

        $truncatedValue = u($field->getFormattedValue())
            ->truncate(self::MAX_LENGTH, '...', false);

        $field->setFormattedValue($truncatedValue);
    }
}