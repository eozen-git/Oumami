<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $total_price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $retrieval_datetime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getRetrievalDatetime(): ?\DateTimeInterface
    {
        return $this->retrieval_datetime;
    }

    public function setRetrievalDatetime(\DateTimeInterface $retrieval_datetime): self
    {
        $this->retrieval_datetime = $retrieval_datetime;

        return $this;
    }
}
