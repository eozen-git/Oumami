<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\OrderDetail;
use App\Form\CartType;
use App\Repository\DishRepository;
use App\Repository\OrderRepository;
use App\Service\ValidationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrderController
 * @package App\Controller
 * @Route("/commande")
 */
class OrderController extends AbstractController
{
    /**
     * @Route ("", name="order")
     * @param DishRepository $dishRepository
     * @param Request $request
     * @param SessionInterface $session
     * @param ValidationManager $validationManager
     * @return Response
     */
    public function index(DishRepository $dishRepository, Request $request, SessionInterface $session, ValidationManager $validationManager)
    {
        $dishes = $dishRepository->findBy([]);
        $cart = $session->get('cart');

        if (!isset($cart)) {
            $cart = new Cart();
            foreach ($dishes as $dish) {
                $orderDetail = new OrderDetail();
                $orderDetail->setFood($dish);

                $cart->addOrderDetail($orderDetail);
            }
        }

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $empty = $validationManager->emptyCheck($data->getOrderDetails());
            if ($empty == 0) {
                $this->addFlash(
                    'danger',
                    'Le panier est vide. Merci de saisir une commande.'
                );

                return $this->render('order/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $session->set('data', $data);
            $session->set('cart', $cart);

            return $this->redirectToRoute('cart');
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/liste", name="commands_list")
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function list(OrderRepository $orderRepository) {
        $orders = $orderRepository->findBy([]);

        return $this->render('order/list.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/reset", name="reset")
     * @param SessionInterface $session
     * @return Response
     */
    public function reset(SessionInterface $session) {
        $session->remove('cart');
        $session->clear();

        return $this->redirectToRoute('order');
    }
}
