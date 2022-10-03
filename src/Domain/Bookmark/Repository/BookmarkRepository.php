<?php

namespace Domain\Bookmark\Repository;

use Domain\Bookmark\Model\Bookmark;

interface BookmarkRepository
{
    public function findById(int $id): ?Bookmark;

    public function persist(Bookmark $bookmark): void;
}
