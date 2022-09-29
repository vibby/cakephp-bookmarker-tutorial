<?php

namespace App\Controller\Component;

use Application\GetBookmark\GetBookmarkHandler;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Exception;

/**
 * @property BookmarkRepositoryComponent $BookmarkRepository
 */
class ContainerComponent extends Component
{
    public $components = ['BookmarkRepository'];
    private $container = [];

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $this->container[GetBookmarkHandler::class] = new GetBookmarkHandler($this->BookmarkRepository); // On crée nos services ici
    }

    public function get($serviceName)
    {
        if (!isset($this->container[$serviceName])) {
            throw new Exception('Cannot find service');
        }

        return $this->container[$serviceName];
    }
}
