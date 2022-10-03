<?php

namespace Application\GetBookmark;

class GetBookmarkInput
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
