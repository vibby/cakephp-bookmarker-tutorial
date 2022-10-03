<?php

namespace Application\UpdateBookmark;

class UpdateBookmarkInput
{
    public int $id;
    public string $title;
    public string $url;
    public string $description;

    /**
     * @var array<string>
     */
    public array $tagsTitle;
}
