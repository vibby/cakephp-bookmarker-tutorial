<?php

declare(strict_types=1);

namespace App\Symfony\Doctrine\Type;

use App\Domain\Bookmark\ValueObject\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UrlType extends StringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Url
    {
        if (!$value) {
            return null;
        }

        return Url::fromPersistedString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value instanceof Url) {
            return null;
        }

        return $value->value;
    }

    public function getName(): string
    {
        return 'vo_url';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
