<?php

namespace App\Controller\Component;

use App\Model\Entity\Bookmark;
use Cake\Controller\Component;
use Domain\Bookmark\Model\Bookmark as BookmarkModel;
use Domain\Bookmark\ValueObject\Url;

/**
 * @property TagTransformerComponent  $TagTransformer
 * @property UserTransformerComponent $UserTransformer
 */
class BookmarkTransformerComponent extends Component
{
    public $components = ['TagTransformer', 'UserTransformer'];

    public function modelToEntity(BookmarkModel $bookmarkModel): Bookmark
    {
        $bookmarkEntity = new Bookmark();
        $bookmarkEntity->set('title', $bookmarkModel->title);
        $bookmarkEntity->set('url', $bookmarkModel->url->value);
        $bookmarkEntity->set('description', $bookmarkModel->description);
        $bookmarkEntity->set('id', $bookmarkModel->id);

        if ($bookmarkModel->user) {
            $bookmarkEntity->set('user', $this->UserTransformer->modelToEntity($bookmarkModel->user));
        }
        if ($bookmarkModel->tags) {
            $bookmarkEntity->set('tags', array_map(
                function ($tagModel) {
                    return $this->TagTransformer->modelToEntity($tagModel);
                },
                $bookmarkModel->tags
            ));
        }

        return $bookmarkEntity;
    }

    public function EntityToModel(Bookmark $bookmarkEntity): BookmarkModel
    {
        $bookmarkModel = new BookmarkModel();
        $bookmarkModel->id = $bookmarkEntity->id;
        $bookmarkModel->title = $bookmarkEntity->get('title');
        $bookmarkModel->url = Url::fromPersistedString($bookmarkEntity->get('url'));
        $bookmarkModel->description = $bookmarkEntity->get('description');

        if ($bookmarkEntity->get('user')) {
            $bookmarkModel->user = $this->UserTransformer->entityToModel($bookmarkEntity->get('user'));
        }

        if ($bookmarkEntity->get('tags')) {
            $bookmarkModel->tags = array_map(
                function ($tagEntity) {
                    return $this->TagTransformer->entityToModel($tagEntity);
                },
                $bookmarkEntity->get('tags')
            );
        }

        return $bookmarkModel;
    }
}
