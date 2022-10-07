<?php

namespace App\Application\GetBookmark;

use App\Application\Handler;
use App\Domain\Bookmark\Model\Bookmark;
use App\Domain\Bookmark\Repository\BookmarkRepository;

class GetBookmarkHandler implements Handler
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
