<?php

namespace App\Domain\Bookmark\Model;

use DateTimeImmutable;

class User
{
    public int $id;
    public string $email;
    public string $password;
    public \DateTime $dateOfBirth;

    /** @var array<Bookmark> */
    public array $bookmarks;

    public DateTimeImmutable $created;
    public DateTimeImmutable $modified;
}
