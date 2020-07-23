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
     * @ORM\ManyToOne(targetEntity=order::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * @ORM\ManyToOne(targetEntity=dish::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $food;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero(message="La quantité d'un plat doit être égale ou supérieure à 0")
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

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
