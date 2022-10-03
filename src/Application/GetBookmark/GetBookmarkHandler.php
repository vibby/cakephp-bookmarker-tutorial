<?php

namespace Application\GetBookmark;

use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Repository\BookmarkRepository;

class GetBookmarkHandler
{
    public function __construct(
        private readonly BookmarkRepository $bookmarkRepository
    ) {
    }

    public function __invoke(
        GetBookmarkInput $input
    ): ?Bookmark {
        return $this->bookmarkRepository->findById($input->id);
    }
}
