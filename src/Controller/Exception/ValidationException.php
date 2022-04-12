<?php

declare(strict_types=1);

namespace App\Controller\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends BadRequestHttpException implements \JsonSerializable
{
    private ConstraintViolationListInterface $constraintViolationList;
    public function __construct(ConstraintViolationListInterface $constraintViolationList, ?string $message = null)
    {
        parent::__construct($message);
        $this->constraintViolationList = $constraintViolationList;
    }

    public function jsonSerialize(): array
    {
        $errors = [];
        foreach ($this->constraintViolationList as $violation) {
            $path = $violation->getPropertyPath();
            $errors[$path] = [
                'code' => $violation->getCode(),
                'msg' => $violation->getMessage(),
            ];
        }

        return [
            'code' => $this->getCode(),
            'msg' => $this->getMessage(),
            'errors' => $errors,
        ];
    }
}
