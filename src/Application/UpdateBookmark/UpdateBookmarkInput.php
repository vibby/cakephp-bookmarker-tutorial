<?php

namespace App\Application\UpdateBookmark;

class UpdateBookmarkInput
{
    /**
     * @param array<string> $tagsTitle
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $url,
        public readonly string $description,
        public readonly array $tagsTitle,
    ) {
    }
}
