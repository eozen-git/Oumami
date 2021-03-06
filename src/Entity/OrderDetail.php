<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * @ORM\ManyToOne(targetEntity="Dish", cascade={"persist"})
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id", nullable=false)
     */
    private $food;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message="La quantité d'un plat commandé doit être supérieure à 0")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommand(): ?order
    {
        return $this->command;
    }

    public function setCommand(?order $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getFood(): ?dish
    {
        return $this->food;
    }

    public function setFood(?dish $food): self
    {
        $this->food = $food;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
