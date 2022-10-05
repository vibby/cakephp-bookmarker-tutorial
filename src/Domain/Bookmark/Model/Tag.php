<?php

namespace App\Domain\Bookmark\Model;

use DateTimeImmutable;

class Tag
{
    public int $id;
    public string $title;

    /** @var array<Bookmark> */
    public array $bookmarks;

    public DateTimeImmutable $created;
    public DateTimeImmutable $modified;
}
