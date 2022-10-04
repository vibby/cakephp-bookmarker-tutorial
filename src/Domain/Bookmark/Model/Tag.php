<?php

namespace App\Domain\Bookmark\Model;

class Tag
{
    public int $id;
    public string $title;

    /** @var array<Bookmark> */
    public array $bookmarks;
}
