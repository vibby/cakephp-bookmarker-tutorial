<?php

namespace App\Domain\Bookmark\Context;

use App\Domain\Bookmark\Model\User;

interface CurrentUserProvider
{
    public function getCurrentUser(): ?User;
}
