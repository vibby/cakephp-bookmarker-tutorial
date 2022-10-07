<?php

namespace App\Test\Application\UpdateBookmark;

use App\Application\UpdateBookmark\UpdateBookmarkInput;
use App\Application\UpdateBookmark\UpdateBookmarkValidator;
use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class UpdateBookmarkValidatorTest extends TestCase
{
    private UpdateBookmarkValidator $validator;
    private ViolationCollector|MockObject $violationCollector;

    public function setUp(): void
    {
        $this->violationCollector = $this->createMock(ViolationCollector::class);
        $this->validator = new UpdateBookmarkValidator(
            $this->violationCollector,
        );
    }

    public function testValidInput()
    {
        $input = new UpdateBookmarkInput(
            id: 12,
            title: 'Just a title',
            url: 'http://example.com',
            description: 'A simple descr',
            tagsTitle: [],
        );

        $this->violationCollector->expects($this->never())->method('collect');

        $this->validator->validate($input);
    }

    public function testTitleTooShort()
    {
        $input = new UpdateBookmarkInput(
            id: 12,
            title: 'Ju',
            url: 'http://example.com',
            description: 'A simple descr',
            tagsTitle: [],
        );

        $this->violationCollector->expects($this->once())->method('collect')->with(
            new Violation('Title must be at last 3 char long.', 'title')
        );

        $this->validator->validate($input);
    }
}
