<?php

namespace App\Domain\Bookmark\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class User
{
    public int $id;
    public string $email;
    public string $password;
    public \DateTime $dateOfBirth;

    /** @var array<Bookmark>|Collection<int, Tag> */
    public array|Collection $bookmarks;

    public DateTimeImmutable $created;
    public DateTimeImmutable $modified;
}
