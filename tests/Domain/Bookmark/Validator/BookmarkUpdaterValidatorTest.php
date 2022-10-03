<?php

namespace App\Test\Domain\Bookmark\Validator;

use Domain\Bookmark\Context\CurrentUserProvider;
use Domain\Bookmark\Model\Bookmark;
use Domain\Bookmark\Model\User;
use Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class BookmarkUpdaterValidatorTest extends TestCase
{
    private BookmarkUpdaterValidator $validator;

    public function setUp(): void
    {
        $this->currentUserProvider = $this->createMock(CurrentUserProvider::class);
        $this->validator = new BookmarkUpdaterValidator($this->currentUserProvider);
    }

    public function testSameUser()
    {
        $user = $this->createMock(User::class);
        $user->id = 12;
        $this->currentUserProvider->method('getCurrentUser')->willReturn($user);

        $bookmark = $this->createMock(Bookmark::class);
        $user2 = $this->createMock(User::class);
        $user2->id = 12;
        $bookmark->user = $user2;

        self::assertEmpty($this->validator->validate($bookmark));
    }

    public function testDifferentUser()
    {
        $user = $this->createMock(User::class);
        $user->id = 12;
        $this->currentUserProvider->method('getCurrentUser')->willReturn($user);

        $bookmark = $this->createMock(Bookmark::class);
        $user2 = $this->createMock(User::class);
        $user2->id = 13;
        $bookmark->user = $user2;

        self::assertEquals($this->validator->validate($bookmark), ['You cannot modify that bookmark since you are not the owner']);
    }

    public function testCannotFindCurrentUser()
    {
        $this->currentUserProvider->method('getCurrentUser')->willReturn(null);

        $bookmark = $this->createMock(Bookmark::class);
        $user2 = $this->createMock(User::class);
        $user2->id = 13;
        $bookmark->user = $user2;

        self::assertEquals($this->validator->validate($bookmark), ['You cannot modify that bookmark since you are not the owner']);
    }
}
