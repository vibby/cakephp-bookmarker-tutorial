<?php

namespace App\Controller\Component;

use App\Model\Entity\User as UserEntity;
use Cake\Controller\Component;
use Domain\Bookmark\Model\User as UserModel;

class UserTransformerComponent extends Component
{
    public function modelToEntity(UserModel $userModel): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity->set('id', $userModel->id);
        $userEntity->set('email', $userModel->email);

        return $userEntity;
    }

    public function EntityToModel(UserEntity $userEntity): UserModel
    {
        $userModel = new UserModel();
        $userModel->id = $userEntity->id;
        $userModel->email = $userEntity->get('email');

        return $userModel;
    }
}
