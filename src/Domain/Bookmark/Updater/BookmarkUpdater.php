<?php

namespace Domain\Bookmark\Updater;

use Domain\Bookmark\Model\Bookmark;

class BookmarkUpdater
{
    public function update(
        Bookmark $bookmark,
        string $title,
        string $url,
        string $description
    ): ?Bookmark {
        $bookmark->title = $title;
        $bookmark->url = $url;
        $bookmark->description = $description;

        return $bookmark;
    }
}
