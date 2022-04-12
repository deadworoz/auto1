<?php

declare(strict_types=1);

namespace App\Controller\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends BadRequestHttpException implements \JsonSerializable
{
    private ConstraintViolationListInterface $constraintViolationList;
    public function __construct(ConstraintViolationListInterface $constraintViolationList, ?string $message = null, \Throwable $previous = null)
    {
        parent::__construct($message, $previous, Response::HTTP_BAD_REQUEST);
        $this->constraintViolationList = $constraintViolationList;
    }

    public function jsonSerialize(): array
    {
        $errors = [];
        foreach ($this->constraintViolationList as $violation) {
            $path = $violation->getPropertyPath();
            $errors[] = [
                'code' => $violation->getCode(),
                'name' => $path,
                'reason' => $violation->getMessage(),
            ];
        }

        return [
            'code' => $this->getCode(),
            'msg' => $this->getMessage(),
            'errors' => $errors,
        ];
    }
}
