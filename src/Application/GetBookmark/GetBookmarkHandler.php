<?php

namespace Application\GetBookmark;

use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Repository\BookmarkRepository;

class GetBookmarkHandler
{
    private $bookmarkRepository;

    public function __construct(
        BookmarkRepository $bookmarkRepository
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    public function __invoke(
        GetBookmarkInput $input
    ): ?Bookmark {
        return $this->bookmarkRepository->findById($input->id);
    }
}
