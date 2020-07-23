<?php


namespace App\Controller;


use App\Entity\Order;
use App\Form\OrderType;
use App\Service\CalculationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     * @param SessionInterface $session
     * @param Request $request
     * @param CalculationManager $calculationManager
     * @return Response
     */
    public function index(SessionInterface $session, Request $request, CalculationManager $calculationManager)
    {
        $orderDetails = ($session->get('cart'))->getOrderDetails();

        $order = new Order();
        foreach ($orderDetails as $orderDetail) {
            $order->addOrderDetail($orderDetail);
        }
        $order->setTotalPrice($calculationManager->check($order));

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        return $this->render('cart/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}