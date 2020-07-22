<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Cart
{
    private $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
        }

        return $this;
    }
}