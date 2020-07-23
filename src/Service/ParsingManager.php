<?php


namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

class ParsingManager
{
    public function removeOrderZeroQuantity(ArrayCollection $cart): ArrayCollection
    {
        for ($i = 0; $i < count($cart); $i++) {
                if ($cart[$i]->getQuantity() == null) {
                    unset($cart[$i]);
                }
        }
        return $cart;
    }
}