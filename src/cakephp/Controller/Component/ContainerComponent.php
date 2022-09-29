<?php

namespace App\Controller\Component;

use Application\GetBookmark\GetBookmarkHandler;
use Application\UpdateBookmark\UpdateBookmarkHandler;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Domain\Bookmark\Updater\BookmarkUpdater;
use Exception;

/**
 * @property BookmarkRepositoryComponent $BookmarkRepository
 * @property TagRepositoryComponent $TagRepository
 */
class ContainerComponent extends Component
{
    public $components = ['BookmarkRepository', 'TagRepository'];
    private $container = [];

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $this->container[GetBookmarkHandler::class] = new GetBookmarkHandler($this->BookmarkRepository); // On crée nos services ici
        $this->container[BookmarkUpdater::class] = new BookmarkUpdater($this->TagRepository);
        $this->container[UpdateBookmarkHandler::class] = new UpdateBookmarkHandler($this->BookmarkRepository, $this->container[BookmarkUpdater::class]);
    }

    public function get($serviceName)
    {
        if (!isset($this->container[$serviceName])) {
            throw new Exception('Cannot find service');
        }

        return $this->container[$serviceName];
    }
}
