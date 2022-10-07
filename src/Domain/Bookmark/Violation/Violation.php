<?php

namespace App\Domain\Bookmark\Violation;

class Violation
{
    public function __construct(
        public readonly string $message,
        public readonly ?string $propertyPath = null,
    ) {
    }
}
