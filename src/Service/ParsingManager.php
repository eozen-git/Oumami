<?php


namespace App\Service;

use App\Entity\Cart;
use Doctrine\Common\Collections\ArrayCollection;

class ParsingManager
{
    public function removeOrderZeroQuantity(Cart $cart): Cart
    {
        $orders = $cart->getOrderDetails();
        for ($i = 0; $i < count($orders); $i++) {
            if ($orders[$i]->getQuantity() == null) {
                unset($orders[$i]);
            }
        }
        return $cart;
    }
}