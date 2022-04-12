<?php

declare(strict_types=1);

namespace App\Controller\Exception;

use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @OA\Schema(
 *  @OA\Property(property="code", type="int"),
 *  @OA\Property(property="msg", type="string"),
 *  @OA\Property(
 *    property="errors",
 *    type="array",
 *    @OA\Items(
 *      @OA\Property(property="code", type="string", nullable=true),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="reason", type="string")
 *    )
 *  )
 * )
 */
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
