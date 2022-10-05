<?php

namespace App\Domain\Bookmark\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class Tag
{
    public int $id;
    public string $title;

    /** @var array<Bookmark>|Collection<int, Tag> */
    public array|Collection $bookmarks;

    public DateTimeImmutable $created;
    public DateTimeImmutable $modified;
}
