<?php

namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;
use Domain\Bookmark\Context\CurrentUserProvider;
use Domain\Bookmark\Model\User as UserModel;

/**
 * @property UserTransformerComponent $UserTransformer
 * @property AuthComponent $Auth
 */
class CurrentUserProviderComponent extends Component implements CurrentUserProvider
{
    public $components = ['Auth', 'UserTransformer'];

    public function getCurrentUser(): ?UserModel
    {
        return $this->UserTransformer->EntityToModel(new User($this->Auth->user()));
    }
}
