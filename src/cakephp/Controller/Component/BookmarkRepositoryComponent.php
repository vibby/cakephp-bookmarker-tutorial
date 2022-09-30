<?php

namespace App\Controller\Component;

use App\Model\Entity\Bookmark;
use App\Model\Table\BookmarksTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Domain\Bookmark\Model\Bookmark as BookmarkModel;
use Domain\Bookmark\Repository\BookmarkRepository;

/**
 * @property BookmarksTable $Bookmarks
 * @property BookmarkTransformerComponent $BookmarkTransformer
 */
class BookmarkRepositoryComponent extends Component implements BookmarkRepository
{
    public $components = ['BookmarkTransformer'];

    public function findById(string $id): ?BookmarkModel
    {
        $Bookmarks = TableRegistry::get('Bookmarks');
        $bookmarkEntity = $Bookmarks->get($id, [
            'contain' => ['Users', 'Tags']
        ]);
        if (!$bookmarkEntity instanceof Bookmark) {
            return null;
        }
        return $this->BookmarkTransformer->EntityToModel($bookmarkEntity);
    }
}
