<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\OrderDetail;
use App\Form\CartType;
use App\Repository\DishRepository;
use App\Service\ParsingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande", name="order")
     * @param DishRepository $dishRepository
     * @param Request $request
     * @param SessionInterface $session
     * @param ParsingManager $parsingManager
     * @return Response
     */
    public function index(DishRepository $dishRepository, Request $request, SessionInterface $session, ParsingManager $parsingManager)
    {
        $dishes = $dishRepository->findBy([]);

        $cart = new Cart();
        foreach ($dishes as $dish) {
            $orderDetail = new OrderDetail();
            $orderDetail->setFood($dish);
            $orderDetail->setQuantity(0);

            $cart->addOrderDetail($orderDetail);
        }

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $parsingManager->removeOrderZeroQuantity($cart);

            $session->set('cart', $cart);

            return $this->redirectToRoute('cart');
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}