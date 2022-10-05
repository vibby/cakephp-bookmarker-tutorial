<?php

declare(strict_types=1);

namespace App\Symfony\Serializer;

use App\Domain\Bookmark\ValueObject\Url;
use Exception;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class UrlSerializer implements NormalizerInterface
{
    /**
     * {@inheritDoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$object instanceof Url) {
            throw new Exception('Invalid Type. Url Required.');
        }

        return $object->value;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof Url;
    }
}
