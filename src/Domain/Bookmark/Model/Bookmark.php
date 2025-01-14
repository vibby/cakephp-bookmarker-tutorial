<?php

namespace App\Domain\Bookmark\Model;

use App\Domain\Bookmark\ValueObject\Url;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class Bookmark
{
    public int $id;
    public string $title;
    public Url $url;
    public string $description;
    public User $user;

    /** @var array<Tag>|Collection<int, Tag> */
    public array|Collection $tags;

    public DateTimeImmutable $created;
    public DateTimeImmutable $modified;
}
