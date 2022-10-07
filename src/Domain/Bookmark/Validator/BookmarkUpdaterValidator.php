<?php

namespace App\Domain\Bookmark\Validator;

use App\Domain\Bookmark\Context\CurrentUserProvider;
use App\Domain\Bookmark\Model\Bookmark;
use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;

class BookmarkUpdaterValidator
{
    public function __construct(
        private readonly CurrentUserProvider $currentUserProvider,
        private readonly ViolationCollector $violationCollector,
    ) {
    }

    public function validate(Bookmark $bookmark): void
    {
        $currentUser = $this->currentUserProvider->getCurrentUser();
        if (null !== $currentUser && $currentUser->id !== $bookmark->user->id) {
            $this->violationCollector->collect(new Violation('You cannot modify that bookmark since you are not the owner'));
        }
    }
}
