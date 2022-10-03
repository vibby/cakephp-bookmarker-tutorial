<?php

namespace Application\UpdateBookmark;

    class UpdateBookmarkValidator
    {
        public function validate(
            UpdateBookmarkInput $input
        ): array {
            $violations = [];
            if (mb_strlen($input->title) < 3) {
                $violations[] = 'Title must be at last 3 char long.';
            }
            if (mb_strlen($input->title) > 1024) {
                $violations[] = 'Title cannot be more than 1024 char long.';
            }

            return $violations;
        }
    }
