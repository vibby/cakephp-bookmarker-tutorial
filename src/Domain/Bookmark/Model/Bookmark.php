<?php

namespace App\Domain\Bookmark\Model;

use App\Domain\Bookmark\ValueObject\Url;

class Bookmark
{
    public int $id;
    public string $title;
    public Url $url;
    public string $description;
    public User $user;

    /** @var array<Tag> */
    public array $tags;
}
