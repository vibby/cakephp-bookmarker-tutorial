<?php

namespace App\Application\GetBookmark;

class GetBookmarkInput
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
