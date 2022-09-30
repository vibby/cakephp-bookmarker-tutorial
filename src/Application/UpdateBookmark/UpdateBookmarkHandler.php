<?php

namespace Application\UpdateBookmark;

use Domain\Bookmark\Exception\ViolationCollectionException;
use Domain\Bookmark\Repository\BookmarkRepository;
use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Updater\BookmarkUpdater;
use Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use Domain\Bookmark\ValueObject\InvalidValueException;
use Domain\Bookmark\ValueObject\Url;

class UpdateBookmarkHandler
{
    private $bookmarkRepository;
    private $updater;
    private $inputValidator;
    private $updateValidator;

    public function __construct(
        BookmarkRepository $bookmarkRepository,
        BookmarkUpdater $updater,
        UpdateBookmarkValidator $updateBookmarkValidator,
        BookmarkUpdaterValidator $bookmarkUpdaterValidator
	) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->updater = $updater;
        $this->inputValidator = $updateBookmarkValidator;
        $this->updateValidator = $bookmarkUpdaterValidator;
    }

    public function __invoke(
        UpdateBookmarkInput $input
	): ?Bookmark {
        $errors = $this->inputValidator->validate($input);
        $bookmark = $this->bookmarkRepository->findById($input->id);
        if (!$bookmark) {
            $errors[] = 'Bookmark does not exists.';
        } else {
            $errors = array_merge($errors, $this->updateValidator->validate($bookmark));
        }
        try {
            $url = Url::fromString($input->url);
        } catch (InvalidValueException $exception) {
            $errors[] = $exception->getMessage();
        }
        if (count($errors)) {
            throw new ViolationCollectionException('Errors occured with your request', $errors);
        }
        $bookmark = $this->updater->update(
            $bookmark,
            $input->title,
            $url,
            $input->description,
            $input->tagsTitle
        );

        if ($bookmark) {
            $this->bookmarkRepository->persist($bookmark);
        }

        return $bookmark;
    }
}
