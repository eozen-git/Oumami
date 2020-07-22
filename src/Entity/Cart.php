<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Cart
{
    private $dishes;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }

    public function getDishes()
    {
        return $this->dishes;
    }

    public function addActivity(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes[] = $dish;
        }

        return $this;
    }
}