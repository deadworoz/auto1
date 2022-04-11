<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BackedEnumResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $type = $argument->getType();
        if ($type === null) {
            return false;
        }

        if (!class_exists($type)) {
            return false;
        }

        try {
            $reflection = new \ReflectionClass($type);
        } catch (\ReflectionException $e) {
            return false;
        }

        return $reflection->implementsInterface(\BackedEnum::class)
            && $reflection->implementsInterface(ResolvableEnumInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $enumClass = $argument->getType();
        assert($enumClass !== null);

        $name = $argument->getName();
        $value = null;
        foreach ($this->getParameterBags($request) as $bag) {
            if ($bag->has($name)) {
                $value = $bag->get($name);
            }
        }

        if (is_string($value)) {
            return [$this->returnCaseOrThrow($value, $enumClass)];
        }

        if ($argument->isNullable()) {
            return [null];
        }

        throw new BadRequestHttpException("Argument {$name} is not nullable");
    }

    private function returnCaseOrThrow(string $value, string $enumClass): mixed
    {
        assert(class_exists($enumClass));
        $valueInt = filter_var($value, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        $value = $valueInt ?? $value;
        $case = $enumClass::tryFrom($value);
        if ($case === null) {
            throw new BadRequestHttpException("Invalid value for enum {$enumClass}");
        }

        return $case;
    }

    /**
     * @return ParameterBag[]
     */
    private function getParameterBags(Request $request): array
    {
        return [$request->attributes, $request->query];
    }
}
