<?php

namespace App\Test\Application\UpdateBookmark;

use Application\UpdateBookmark\UpdateBookmarkInput;
use Application\UpdateBookmark\UpdateBookmarkValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class UpdateBookmarkValidatorTest extends TestCase
{
    private UpdateBookmarkValidator $validator;

    public function setUp(): void
    {
        $this->validator = new UpdateBookmarkValidator();
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

        $this->assertEmpty($this->validator->validate($input));
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

        $this->assertEquals($this->validator->validate($input), ['Title must be at last 3 char long.']);
    }
}
