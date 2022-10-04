<?php

namespace App\Controller\Component;

use App\Domain\Bookmark\Model\Bookmark as BookmarkModel;
use App\Domain\Bookmark\Repository\BookmarkRepository;
use App\Model\Entity\Bookmark;
use App\Model\Table\BookmarksTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * @property BookmarksTable               $Bookmarks
 * @property BookmarkTransformerComponent $BookmarkTransformer
 */
class BookmarkRepositoryComponent extends Component implements BookmarkRepository
{
    public $components = ['BookmarkTransformer'];

    public function findById(int $id): ?BookmarkModel
    {
        $Bookmarks = TableRegistry::get('Bookmarks');
        $bookmarkEntity = $Bookmarks->get($id, [
            'contain' => ['Users', 'Tags'],
        ]);
        if (!$bookmarkEntity instanceof Bookmark) {
            return null;
        }

        return $this->BookmarkTransformer->EntityToModel($bookmarkEntity);
    }

    public function persist(BookmarkModel $bookmark): void
    {
        $Bookmarks = TableRegistry::get('Bookmarks');
        $Bookmarks->save($this->BookmarkTransformer->ModelToEntity($bookmark));
    }
}
