<?php

namespace Domain\Bookmark\Context;

use Domain\Bookmark\Model\User;

interface CurrentUserProvider
{
    public function getCurrentUser(): ?User;
}
