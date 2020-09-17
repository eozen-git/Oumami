<?php


namespace App\Form;

use App\Entity\Cart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('orderDetails', CollectionType::class, [
            'entry_type' => OrderDetailType::class,
            'entry_options' => ['label' => false],
        ])
        ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
        $data = $event->getData();

        $orderDetails = new Cart();
        foreach ($data->getOrderDetails() as $orderDetail) {
            if ($orderDetail->getQuantity() !== 0 && $orderDetail->getQuantity() !== null) {
                $orderDetails->addOrderDetail($orderDetail);
            }
        }
        $event->setData($orderDetails);
    })
        ->add('Panier', SubmitType::class, [
            'attr' => ['class' => 'btn btn-lg btn-primary ml-4'],
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
