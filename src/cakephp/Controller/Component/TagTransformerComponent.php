<?php

namespace App\Controller\Component;

use App\Model\Entity\Tag as TagEntity;
use Cake\Controller\Component;
use Domain\Bookmark\Model\Tag as TagModel;

class TagTransformerComponent extends Component
{
    public function modelToEntity(TagModel $tagModel): TagEntity
    {
        $tagEntity = new TagEntity();
        $tagEntity->set('title', $tagModel->title);
        $tagEntity->set('id', $tagModel->id);

        return $tagEntity;
    }

    public function EntityToModel(TagEntity $tagEntity): TagModel
    {
        $tagModel = new TagModel();
        $tagModel->id = $tagEntity->id;
        $tagModel->title = $tagEntity->get('title');

        return $tagModel;
    }
}
