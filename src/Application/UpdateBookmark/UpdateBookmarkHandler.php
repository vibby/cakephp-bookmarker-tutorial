<?php

namespace App\Application\UpdateBookmark;

use App\Application\Handler;
use App\Domain\Bookmark\Exception\ViolationCollectionException;
use App\Domain\Bookmark\Model\Bookmark;
use App\Domain\Bookmark\Repository\BookmarkRepository;
use App\Domain\Bookmark\Updater\BookmarkUpdater;
use App\Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use App\Domain\Bookmark\ValueObject\InvalidValueException;
use App\Domain\Bookmark\ValueObject\Url;

class UpdateBookmarkHandler implements Handler
{
    public function __construct(
        private readonly BookmarkRepository $bookmarkRepository,
        private readonly BookmarkUpdater $updater,
        private readonly UpdateBookmarkValidator $inputValidator,
        private readonly BookmarkUpdaterValidator $updateValidator,
    ) {
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
            $url = null;
            $errors[] = $exception->getMessage();
        }
        if (count($errors)) {
            throw new ViolationCollectionException('Errors occured with your request', $errors);
        }
        if (!$bookmark instanceof Bookmark) {
            throw new \LogicException('Bookmark is undefined');
        }
        if (!$url instanceof Url) {
            throw new \LogicException('Url is undefined');
        }
        $bookmark = $this->updater->update(
            $bookmark,
            $input->title,
            $url,
            $input->description,
            $input->tagsTitle
        );

        if ($bookmark instanceof Bookmark) {
            $this->bookmarkRepository->persist($bookmark);
        }

        return $bookmark;
    }
}
