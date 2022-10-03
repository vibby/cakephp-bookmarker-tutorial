<?php

namespace App\Controller\Component;

use Application\GetBookmark\GetBookmarkHandler;
use Application\UpdateBookmark\UpdateBookmarkHandler;
use Application\UpdateBookmark\UpdateBookmarkValidator;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Domain\Bookmark\Updater\BookmarkUpdater;
use Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use Exception;

/**
 * @property BookmarkRepositoryComponent  $BookmarkRepository
 * @property TagRepositoryComponent       $TagRepository
 * @property CurrentUserProviderComponent $CurrentUserProvider
 */
class ContainerComponent extends Component
{
    public $components = ['BookmarkRepository', 'TagRepository', 'CurrentUserProvider'];
    private $container = [];

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $this->container[GetBookmarkHandler::class] = new GetBookmarkHandler($this->BookmarkRepository); // On crée nos services ici
        $this->container[BookmarkUpdater::class] = new BookmarkUpdater($this->TagRepository);
        $this->container[UpdateBookmarkValidator::class] = new UpdateBookmarkValidator();
        $this->container[BookmarkUpdaterValidator::class] = new BookmarkUpdaterValidator($this->CurrentUserProvider);
        $this->container[UpdateBookmarkHandler::class] = new UpdateBookmarkHandler(
            $this->BookmarkRepository,
            $this->container[BookmarkUpdater::class],
            $this->container[UpdateBookmarkValidator::class],
            $this->container[BookmarkUpdaterValidator::class]
        );
    }

    public function get($serviceName)
    {
        if (!isset($this->container[$serviceName])) {
            throw new Exception('Cannot find service');
        }

        return $this->container[$serviceName];
    }
}
