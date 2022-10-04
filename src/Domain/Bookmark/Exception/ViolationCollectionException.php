<?php

namespace App\Domain\Bookmark\Exception;

use Exception;
use Throwable;

class ViolationCollectionException extends Exception
{
    /** @var array<string> */
    public readonly array $violationCollection;

    /**
     * @param array<string> $violationCollection
     */
    public function __construct(string $message, array $violationCollection, int $code = 0, Throwable $previous = null)
    {
        $this->violationCollection = $violationCollection;
        parent::__construct($message, $code, $previous);
    }
}
