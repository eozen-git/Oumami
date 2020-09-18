<?php


namespace App\Service;


use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationManager
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function emptyCheck($orderDetails) {
        $count = 0;
        foreach ($orderDetails as $orderDetail) {
            $count += $orderDetail->getQuantity();
        }
        return $count;
    }
}
