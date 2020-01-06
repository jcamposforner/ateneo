<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus;

use ReflectionException;
use ReflectionClass;
use ReflectionMethod;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;

final class ClassNameResolver
{
    /**
     * @param $class
     * @return string|null
     * @throws ReflectionException
     */
    public function extract($class): ?string
    {
        $reflector = new ReflectionClass($class);
        $method    = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    /**
     * @param iterable $callables
     * @return array
     */
    public static function forCallables(iterable $callables): array
    {
        return map(self::unflatten(), reindex(self::classExtractor(new self()), $callables));
    }

    /**
     * @param ReflectionMethod $method
     * @return string
     */
    private function firstParameterClassFrom(ReflectionMethod $method): string
    {
        return $method->getParameters()[0]->getClass()->getName();
    }

    /**
     * @param ReflectionMethod $method
     * @return bool
     */
    private function hasOnlyOneParameter(ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }

    /**
     * @param ClassNameResolver $parameterExtractor
     * @return callable
     */
    private static function classExtractor(self $parameterExtractor): callable
    {
        return function (callable $handler) use ($parameterExtractor): string {
            return $parameterExtractor->extract($handler);
        };
    }

    /**
     * @return callable
     */
    private static function unflatten(): callable
    {
        return function ($value) {
            return [$value];
        };
    }
}