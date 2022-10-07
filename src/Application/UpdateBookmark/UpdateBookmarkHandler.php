<?php

namespace App\Application\UpdateBookmark;

use App\Application\Handler;
use App\Domain\Bookmark\Model\Bookmark;
use App\Domain\Bookmark\Repository\BookmarkRepository;
use App\Domain\Bookmark\Updater\BookmarkUpdater;
use App\Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use App\Domain\Bookmark\ValueObject\Url;
use App\Domain\Bookmark\ValueObject\ValueObjectFactory;
use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;

class UpdateBookmarkHandler implements Handler
{
    public function __construct(
        private readonly BookmarkRepository $bookmarkRepository,
        private readonly BookmarkUpdater $updater,
        private readonly UpdateBookmarkValidator $inputValidator,
        private readonly BookmarkUpdaterValidator $updateValidator,
        private readonly ViolationCollector $violationCollector,
        private readonly ValueObjectFactory $valueObjectFactory,
    ) {
    }

    public function __invoke(
        UpdateBookmarkInput $input,
    ): Bookmark|ViolationCollector {
        $this->inputValidator->validate($input);
        $bookmark = $this->bookmarkRepository->findById($input->id);
        if (!$bookmark) {
            $this->violationCollector->collect(new Violation('Bookmark does not exists.'));
        } else {
            $this->updateValidator->validate($bookmark);
        }

        $url = $this->valueObjectFactory->makeFromString(Url::class, $input->url, 'url');
        if ($this->violationCollector->hasViolations() || !$bookmark instanceof Bookmark || !$url instanceof Url) {
            return $this->violationCollector;
        }
        $bookmark = $this->updater->update(
            $bookmark,
            $input->title,
            $url,
            $input->description,
            $input->tagsTitle
        );
        $this->bookmarkRepository->persist($bookmark);

        return $bookmark;
    }
}
