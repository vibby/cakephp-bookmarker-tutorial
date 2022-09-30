<?php

namespace Application\UpdateBookmark;

use Domain\Bookmark\Exception\ViolationCollectionException;
use Domain\Bookmark\Repository\BookmarkRepository;
use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Updater\BookmarkUpdater;
use Domain\Bookmark\ValueObject\Url;

class UpdateBookmarkHandler
{
    private $bookmarkRepository;
    private $updater;
    private $validator;

    public function __construct(
        BookmarkRepository $bookmarkRepository,
        BookmarkUpdater $updater,
        UpdateBookmarkValidator $updateBookmarkValidator
	) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->updater = $updater;
        $this->validator = $updateBookmarkValidator;
    }

    public function __invoke(
        UpdateBookmarkInput $input
	): ?Bookmark {
        $errors = $this->validator->validate($input);
        $bookmark = $this->bookmarkRepository->findById($input->id);
        if (!$bookmark) {
            $errors[] = 'Bookmark does not exists.';
        }
        if (count($errors)) {
            throw new ViolationCollectionException('Errors occured with your request', $errors);
        }
        $bookmark = $this->updater->update(
            $bookmark,
            $input->title,
            Url::fromString($input->url),
            $input->description,
            $input->tagsTitle
        );

        if ($bookmark) {
            $this->bookmarkRepository->persist($bookmark);
        }

        return $bookmark;
    }
}
