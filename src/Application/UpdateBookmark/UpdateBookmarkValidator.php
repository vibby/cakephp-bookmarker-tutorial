<?php

namespace App\Application\UpdateBookmark;

use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;

class UpdateBookmarkValidator
{
    public function __construct(
        private readonly ViolationCollector $violationCollector,
    ) {
    }

    public function validate(
        UpdateBookmarkInput $input
    ): void {
        if (mb_strlen($input->title) < 3) {
            $this->violationCollector->collect(new Violation('Title must be at last 3 char long.', 'title'));
        }
        if (mb_strlen($input->title) > 1024) {
            $this->violationCollector->collect(new Violation('Title cannot be more than 1024 char long.', 'title'));
        }
    }
}
