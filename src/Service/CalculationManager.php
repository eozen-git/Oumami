<?php


namespace App\Service;


use App\Entity\Order;

class CalculationManager
{
    public function check(Order $order): float
    {
        $orders = $order->getOrderDetails();

        $check = 0;
        foreach ($orders as $order) {
            $check += ($order->getQuantity() * $order->getFood()->getPrice());
        }
        return $check;
    }
}