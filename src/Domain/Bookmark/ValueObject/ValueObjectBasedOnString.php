<?php

namespace App\Domain\Bookmark\ValueObject;

interface ValueObjectBasedOnString
{
    public static function fromString(string $value): self;
}
