<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailRepository::class)
 */
class OrderDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=order::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\ManyToOne(targetEntity=dish::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $dish_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?order
    {
        return $this->order_id;
    }

    public function setOrderId(?order $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getDishId(): ?dish
    {
        return $this->dish_id;
    }

    public function setDishId(?dish $dish_id): self
    {
        $this->dish_id = $dish_id;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
