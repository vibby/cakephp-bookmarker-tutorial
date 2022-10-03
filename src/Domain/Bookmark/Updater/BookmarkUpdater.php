<?php

namespace Domain\Bookmark\Updater;

use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Model\Tag;
use Domain\Bookmark\Repository\TagRepository;
use Domain\Bookmark\ValueObject\Url;

class BookmarkUpdater
{
    private $tagRepository;

    public function __construct(
        TagRepository $tagRepository
    ) {
        $this->tagRepository = $tagRepository;
    }

    public function update(
        Bookmark $bookmark,
        string $title,
        Url $url,
        string $description,
        array $tagsTitle
    ): ?Bookmark {
        $bookmark->title = $title;
        $bookmark->url = $url;
        $bookmark->description = $description;
        $bookmark->tags = [];
        foreach ($tagsTitle as $tagTitle) {
            $tag = $this->tagRepository->findByTitle($tagTitle);
            if (!$tag) {
                $tag = new Tag();
                $tag->title = $tagTitle;
            }
            $bookmark->tags[] = $tag;
        }

        return $bookmark;
    }
}
