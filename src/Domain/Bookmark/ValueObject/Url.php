<?php

namespace App\Domain\Bookmark\ValueObject;

class Url
{
    public string $value;

    private function __construct(string $url)
    {
        $this->value = $url;
    }

    public static function fromString(string $url): self
    {
        $validation = (bool) preg_match(
            "#(?i)\\b((?:https?://|www\\d{0,3}[.]|[a-z0-9.\\-]+[.][a-z]{2,4}/)(?:[^\\s()<>]+|\\(([^\\s()<>]+|(\\([^\\s()<>]+\\)))*\\))+(?:\\(([^\\s()<>]+|(\\([^\\s()<>]+\\)))*\\)|[^\\s`!()\\[\\]{};:'\".,<>?«»“”‘’]))#",
            $url
        );
        if (!$validation) {
            throw new InvalidValueException('Invalid URL');
        }

        return new self($url);
    }

    public static function fromPersistedString(string $url): self
    {
        return new self($url);
    }
}
