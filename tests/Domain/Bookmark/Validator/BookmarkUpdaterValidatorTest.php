<?php

namespace App\Test\Domain\Bookmark\Validator;

use App\Domain\Bookmark\Context\CurrentUserProvider;
use App\Domain\Bookmark\Model\Bookmark;
use App\Domain\Bookmark\Model\User;
use App\Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use App\Domain\Bookmark\Violation\Violation;
use App\Domain\Bookmark\Violation\ViolationCollector;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class BookmarkUpdaterValidatorTest extends TestCase
{
    private BookmarkUpdaterValidator $validator;
    private ViolationCollector|MockObject $violationCollector;

    public function setUp(): void
    {
        $this->currentUserProvider = $this->createMock(CurrentUserProvider::class);
        $this->violationCollector = $this->createMock(ViolationCollector::class);
        $this->validator = new BookmarkUpdaterValidator(
            $this->currentUserProvider,
            $this->violationCollector,
        );
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

        $this->violationCollector->expects($this->never())->method('collect');

        $this->validator->validate($bookmark);
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

        $this->violationCollector->expects($this->once())->method('collect')->with(
            new Violation('You cannot modify that bookmark since you are not the owner')
        );

        $this->validator->validate($bookmark);
    }

    public function acceptNullUser()
    {
        $this->currentUserProvider->method('getCurrentUser')->willReturn(null);

        $bookmark = $this->createMock(Bookmark::class);
        $user2 = $this->createMock(User::class);
        $user2->id = 13;
        $bookmark->user = $user2;

        $this->violationCollector->expects($this->never())->method('collect');

        $this->validator->validate($bookmark);
    }
}
