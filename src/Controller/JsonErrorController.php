<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class JsonErrorController extends AbstractBaseController
{
    public function show(Throwable $exception, ?LoggerInterface $_logger): Response
    {
        $exceptionBody = $exception instanceof \JsonSerializable ? $exception : [
            'code' => $exception->getCode(),
            'msg' => $exception->getMessage(),
        ];

        return $this->json($exceptionBody, $this->getHttpCode($exception));
    }

    private function getHttpCode(Throwable $exception): int
    {
        $statusCode = null;
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        } elseif ($exception instanceof RequestExceptionInterface) {
            $statusCode = 400;
        }

        if ($statusCode === null) {
            $statusCode = 500;
        }

        return $statusCode;
    }
}
