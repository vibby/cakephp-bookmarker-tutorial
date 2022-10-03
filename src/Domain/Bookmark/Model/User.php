<?php

namespace Domain\Bookmark\Model;

class User
{
    public int $id;
    public string $email;
    public string $password;
    public \DateTime $dateOfBirth;

    /** @var array<Bookmark> */
    public array $bookmarks;
}
