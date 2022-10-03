<?php

namespace Domain\Bookmark\Validator;

use Domain\Bookmark\Context\CurrentUserProvider;
use Domain\Bookmark\Model\Bookmark;

class BookmarkUpdaterValidator
{
    public function __construct(
        private readonly CurrentUserProvider $currentUserProvider,
    ) {
    }

    /**
     * @return array<string>
     */
    public function validate(Bookmark $bookmark): array
    {
        $violations = [];
        $currentUser = $this->currentUserProvider->getCurrentUser();
        if (null === $currentUser || $currentUser->id !== $bookmark->user->id) {
            $violations[] = 'You cannot modify that bookmark since you are not the owner';
        }

        return $violations;
    }
}
