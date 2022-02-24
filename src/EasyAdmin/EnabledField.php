<?php

namespace App\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EnabledField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            // this template is used in the index and details page
            ->setTemplatePath('admin/location/enabled.html.twig')
            // this is used in the edit and new pages
            ->setFormType(CheckboxType::class)
            ->addCssClass('field-boolean');
    }
}
