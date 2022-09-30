<?php

namespace Domain\Bookmark\Exception;

use Exception;
use Throwable;

class ViolationCollectionException extends Exception
{
    public $violationCollection;

    public function __construct($message, array $violationCollection, $code = 0, Throwable $previous = null)
    {
        $this->violationCollection = $violationCollection;
        parent::__construct($message, $code, $previous);
    }
}
