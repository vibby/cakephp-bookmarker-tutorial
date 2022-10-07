<?php

namespace App\Domain\Bookmark\ValueObject;

use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;
use Exception;

class ValueObjectFactory
{
    public function __construct(
        private readonly ViolationCollector $violationCollector,
    ) {
    }

    public function makeFromString(string $class, string $value, string $propertyPath): ?ValueObjectBasedOnString
    {
        if (!class_exists($class)) {
            throw new Exception(sprintf('Cannot create value object %s', $class));
        }
        $interfaces = class_implements($class) ?: [];
        if (!in_array(ValueObjectBasedOnString::class, $interfaces)) {
            throw new Exception(sprintf('Cannot create value object %s', $class));
        }

        try {
            return $class::fromString($value);
        } catch (InvalidValueException $exception) {
            $this->violationCollector->collect(new Violation($exception->getMessage(), $propertyPath));
        }

        return null;
    }
}
