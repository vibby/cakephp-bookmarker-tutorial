<?php

namespace App\Controller\Component;

use App\Model\Entity\Bookmark;
use App\Model\Table\BookmarksTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Domain\Bookmark\Model\Bookmark as BookmarkModel;
use Domain\Bookmark\Model\Tag;
use Domain\Bookmark\Model\User;
use Domain\Bookmark\Repository\BookmarkRepository;

/**
 * @property BookmarksTable $Bookmarks
 */
class BookmarkRepositoryComponent extends Component implements BookmarkRepository
{
    public function findById(string $id): ?BookmarkModel
    {
        $Bookmarks = TableRegistry::get('Bookmarks');
        $bookmarkEntity = $Bookmarks->get($id, [
            'contain' => ['Users', 'Tags']
        ]);
        if (!$bookmarkEntity instanceof Bookmark) {
            return null;
        }
        $bookmarkModel = new BookmarkModel();
        $bookmarkModel->id = $bookmarkEntity->id;
        $bookmarkModel->title = $bookmarkEntity->get('title');
        $bookmarkModel->url = $bookmarkEntity->get('url');
        $bookmarkModel->description = $bookmarkEntity->get('description');

        $userModel = new User();
        $userModel->id = $bookmarkEntity->get('user')->get('id');
        $userModel->email = $bookmarkEntity->get('user')->get('email');
        $userModel->dateOfBirth = $bookmarkEntity->get('user')->get('dob');
        $bookmarkModel->user = $userModel;

        foreach ($bookmarkEntity->get('tags') as $tag) {
            $tagModel = new Tag();
            $tagModel->id = $tag->get('id');
            $tagModel->title = $tag->get('title');
            $bookmarkModel->tags[] = $tagModel;
        }

        return $bookmarkModel;
    }
}
