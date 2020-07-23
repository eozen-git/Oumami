<?php


namespace App\Service;

use App\Entity\Cart;

class ParsingManager
{
    public function removeOrderZeroQuantity(Cart $cart): Cart
    {
        $orders = $cart->getOrderDetails();
        $count = count($orders);
        for ($i = 0; $i < $count; $i++) {
            if ($orders[$i]->getQuantity() <= 0) {
                unset($orders[$i]);
            }
        }
        return $cart;
    }
}