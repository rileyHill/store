<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\OrderLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('orderCode')
            ->add('orderDate',DateType::class)
            ->add('customerName')
            ->add('description', TextareaType::class)
            ->add('orderLines', CollectionType::class,[
                'entry_type' => OrderLineType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add'=>true,
                'allow_delete'=>true,
                'prototype' => true,
                'prototype_data'=> new OrderLine(),
                ])
            ->add('Create', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }

}