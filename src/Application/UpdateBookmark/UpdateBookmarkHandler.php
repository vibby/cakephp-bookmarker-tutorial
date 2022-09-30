<?php

namespace Application\UpdateBookmark;

use Domain\Bookmark\Repository\BookmarkRepository;
use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Updater\BookmarkUpdater;

class UpdateBookmarkHandler
{
    private $bookmarkRepository;
    private $updater;

    public function __construct(
        BookmarkRepository $bookmarkRepository,
        BookmarkUpdater $updater
	) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->updater = $updater;
    }

    public function __invoke(
        UpdateBookmarkInput $input
	): ?Bookmark {
        $bookmark = $this->bookmarkRepository->findById($input->id);
        if (!$bookmark) {
            return null;
        }
        $bookmark = $this->updater->update(
            $bookmark,
            $input->title,
            $input->url,
            $input->description
        );

        if ($bookmark) {
            $this->bookmarkRepository->persist($bookmark);
        }

        return $bookmark;
    }
}