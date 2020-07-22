<?php


namespace App\Form;

use App\Entity\Cart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('orderDetails', CollectionType::class, [
            'entry_type' => OrderDetailType::class,
            'entry_options' => ['label' => false],
        ]);
        $builder->add('Enregistrer', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary row mr-5'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cart::class,
            'label' => false,
        ]);
    }
}