<?php

namespace Domain\Bookmark\Validator;

use Domain\Bookmark\Context\CurrentUserProvider;
use Domain\Bookmark\Model\Bookmark;

class BookmarkUpdaterValidator
{
    private $currentUserProvider;

    public function __construct(
        CurrentUserProvider $currentUserProvider
    ) {
        $this->currentUserProvider = $currentUserProvider;
    }

    public function validate(Bookmark $bookmark): array
    {
        $violations = [];
        $currentUser = $this->currentUserProvider->getCurrentUser();
        if ($currentUser === null || $currentUser->id !== $bookmark->user->id) {
            $violations[] = 'You cannot modify that bookmark since you are not the owner';
        }
        return $violations;
    }
}
