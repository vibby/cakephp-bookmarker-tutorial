<?php

namespace App\Controller\Component;

use App\Model\Table\BookmarksTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Domain\Bookmark\Model\Tag;
use Domain\Bookmark\Repository\TagRepository;

/**
 * @property BookmarksTable $Bookmarks
 * @property TagTransformerComponent TagTransformer
 */
class TagRepositoryComponent extends Component implements TagRepository
{
    public $components = ['TagTransformer'];

    public function findByTitle(string $title): ?Tag
    {
        $Tags = TableRegistry::get('Tags');
        $tagEntity = $Tags->find()->where(['Tags.title =' => $title])->first();
        if (!$tagEntity) {
            return null;
        }

        return $this->TagTransformer->EntityToModel($tagEntity);
    }
}