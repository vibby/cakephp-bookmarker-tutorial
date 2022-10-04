<?php

namespace App\Domain\Bookmark\Repository;

use App\Domain\Bookmark\Model\Bookmark;

interface BookmarkRepository
{
    public function findById(int $id): ?Bookmark;

    public function persist(Bookmark $bookmark): void;
}
