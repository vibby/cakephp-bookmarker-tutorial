<?php

namespace Domain\Bookmark\Repository;

use Domain\Bookmark\Model\Tag;

interface TagRepository
{
    public function findByTitle(string $title): ?Tag;
}
