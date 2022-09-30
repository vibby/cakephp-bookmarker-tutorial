<?php

namespace Domain\Bookmark\ValueObject;

class Url
{
    public $value;

    public static function fromString($url) {
        $validation = (bool) preg_match(
            "#(?i)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))#",
            $url
        );
        if (!$validation) {
            throw new InvalidValueException('Invalid URL');
        }

        return new self($url);
    }

    public static function fromPersistedString($url) {
        return new self($url);
    }

    private function __construct(string $url) {
        $this->value = $url;
    }
}
