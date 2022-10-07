<?php

declare(strict_types=1);

namespace App\Symfony\Serializer;

use ApiPlatform\Symfony\Validator\Exception\ValidationException;
use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;
use LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;

final class ViolationCollectorSerializer implements NormalizerInterface
{
    /**
     * {@inheritDoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$object instanceof ViolationCollector) {
            throw new LogicException();
        }

        if (!$object->hasViolations()) {
            throw new LogicException('ViolationCollection cannot be empty');
        }

        $constraintViolations = array_map(static function (Violation $violation): ConstraintViolationInterface {
            return new ConstraintViolation(
                message: $violation->message,
                messageTemplate: $violation->message,
                parameters: [],
                root: null,
                propertyPath: $violation->propertyPath,
                invalidValue: null,
                code: md5($violation->propertyPath.$violation->message),
            );
        }, $object->getViolations());

        throw new ValidationException(new ConstraintViolationList($constraintViolations));
    }

    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof ViolationCollector;
    }
}
