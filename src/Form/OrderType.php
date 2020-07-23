<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderDetails', CollectionType::class, [
                'entry_type' => OrderDetailType::class
            ])
            ->add('retrieval_datetime', DateTimeType::class, [
                'hours' => [
                    12,
                    13,
                    18,
                    19,
                    20
                ],
                'minutes' => [
                    00,
                    10,
                    20,
                    30,
                    40,
                    50,
                ]
            ])
            ->add('customer', CustomerType::class)
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary ml-3 mt-5'],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
