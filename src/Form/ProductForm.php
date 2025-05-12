<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Living Room' => [
                        'Sofas & Couches' => 'Sofas & Couches',
                        'Recliners' => 'Recliners'
                    ],
                    'Bedroom' => [
                        'Beds' => 'Beds',
                        'Wardrobes' => 'Wardrobes'
                    ],
                    'Dining Room' => [
                        'Dining Tables' => 'Dining Tables',
                        'Dining Chairs' => 'Dining Chairs'
                    ],
                    'Office' => [
                        'Desks' => 'Desks',
                        'Office Chairs' => 'Office Chairs'
                    ],
                ],
                'placeholder' => 'Choose a category',
                'required' => true,
            ])
            ->add('imageUrl')
            ->add('stock')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
