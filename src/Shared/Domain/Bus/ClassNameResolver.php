<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus;

use ReflectionException;
use ReflectionClass;
use ReflectionMethod;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;

final class ClassNameResolver
{

    public function extract($class): ?string
    {
        $reflector = new ReflectionClass($class);
        $method    = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    public static function forCallables(iterable $callables): array
    {
        return map(self::unflatten(), reindex(self::classExtractor(new self()), $callables));
    }


    private function firstParameterClassFrom(ReflectionMethod $method): string
    {
        return $method->getParameters()[0]->getClass()->getName();
    }

    private function hasOnlyOneParameter(ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }

    private static function classExtractor(self $parameterExtractor): callable
    {
        return function (callable $handler) use ($parameterExtractor): string {
            return $parameterExtractor->extract($handler);
        };
    }
    private static function unflatten(): callable
    {
        return function ($value) {
            return [$value];
        };
    }
}