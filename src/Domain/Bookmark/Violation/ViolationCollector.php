<?php

namespace App\Domain\Bookmark\Violation;

class ViolationCollector
{
    /**
     * @var array<Violation>
     */
    private array $violations = [];

    public function collect(Violation $violation): void
    {
        $this->violations[] = $violation;
    }

    public function hasViolations(): bool
    {
        return count($this->violations) > 0;
    }

    /**
     * @return Violation[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
