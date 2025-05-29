<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'scale' => 2,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ])

            ->add('imageFile', VichImageType::class, [
                'label' => 'Product Image (JPG, PNG)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete current image?',
                'download_uri' => false,
                'asset_helper' => true,
            ])
            ->add('stock', NumberType::class, [
                'label' => 'Stock Quantity',
            ])
            ->add('category', TextType::class, [
                'label' => 'Category',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}