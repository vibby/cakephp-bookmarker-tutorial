<?php

namespace App\Domain\Bookmark\Repository;

use App\Domain\Bookmark\Model\Tag;

interface TagRepository
{
    public function findByTitle(string $title): ?Tag;
}
