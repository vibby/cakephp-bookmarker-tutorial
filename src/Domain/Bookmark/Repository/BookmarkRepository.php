<?php

namespace Domain\Bookmark\Repository;

use Domain\Bookmark\Model\Bookmark;

interface BookmarkRepository
{
    public function findById(string $id): ?Bookmark;

    public function persist(Bookmark $bookmark): void;
}
