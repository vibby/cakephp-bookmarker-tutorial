<?php

namespace App\Symfony\Security;

use App\Domain\Bookmark\Context\CurrentUserProvider as DomainCurrentUserProvider;
use App\Domain\Bookmark\Model\User;

class CurrentUserProvider implements DomainCurrentUserProvider
{
    public function getCurrentUser(): ?User
    {
        return null;
    }
}
