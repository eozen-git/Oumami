<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande", name="order")
     * @param DishRepository $dishRepository
     * @param Request $request
     * @return Response
     */
    public function index(DishRepository $dishRepository, Request $request)
    {
        $dishes = $dishRepository->findBy([]);

        $orderDetail = new OrderDetail();
        foreach ($dishes as $dish) {
            $userActivity = new UserActivity();
            $userActivity->setActivity($activity->getName());
            $userActivity->setHour($activity->getHour());
            $userActivity->setMinute($activity->getMinute());

            $housingActivity->addActivity($userActivity);
        }

        $form = $this->createForm(OrderDetailType::class);
        $form->handleRequest($request);

        return $this->render('order/index.html.twig', [
            'dishes' => $dishes,
            'form' => $form->createView()
        ]);
    }
}