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

    public function validationLoop($orderDetails) {
        $errorMessages = [];
        foreach ($orderDetails as $orderDetail) {
            $errors = $this->validator->validate($orderDetail);
            for ($i = 0; $i < $errors->count(); $i++) {
                $error = $errors->get($i);
                $errorRoot = $error->getRoot();
                $errorMessages[$errorRoot->getFood()->getName()] = $error->getMessage();
            }
        }
        return $errorMessages;
    }
}