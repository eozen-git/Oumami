<?php

namespace App\Controller;

use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande", name="order")
     * @param DishRepository $dishRepository
     * @return Response
     */
    public function index(DishRepository $dishRepository)
    {
        $dishes = $dishRepository->findBy([]);

        return $this->render('order/index.html.twig', [
            'dishes' => $dishes
        ]);
    }
}