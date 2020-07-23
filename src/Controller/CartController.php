<?php


namespace App\Controller;


use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     * @param SessionInterface $session
     * @return Response
     */
    public function index(SessionInterface $session)
    {
        $orderDetails = ($session->get('cart'))->getOrderDetails();

        $order = new Order();
        foreach ($orderDetails as $orderDetail) {
            $order->addOrderDetail($orderDetail);
        }

        return $this->render('cart/index.html.twig');
    }
}