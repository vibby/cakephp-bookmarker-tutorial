<?php

namespace App\Controller\Component;

use App\Application\GetBookmark\GetBookmarkHandler;
use App\Application\UpdateBookmark\UpdateBookmarkHandler;
use App\Application\UpdateBookmark\UpdateBookmarkValidator;
use App\Domain\Bookmark\Updater\BookmarkUpdater;
use App\Domain\Bookmark\Validator\BookmarkUpdaterValidator;
use App\Domain\Bookmark\ValueObject\ValueObjectFactory;
use App\Domain\Bookmark\Violation\ViolationCollector;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
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
        $this->container[ViolationCollector::class] = new ViolationCollector();
        $this->container[ValueObjectFactory::class] = new ValueObjectFactory($this->container[ViolationCollector::class]);
        $this->container[UpdateBookmarkValidator::class] = new UpdateBookmarkValidator($this->container[ViolationCollector::class]);
        $this->container[BookmarkUpdaterValidator::class] = new BookmarkUpdaterValidator($this->CurrentUserProvider, $this->container[ViolationCollector::class]);
        $this->container[UpdateBookmarkHandler::class] = new UpdateBookmarkHandler(
            $this->BookmarkRepository,
            $this->container[BookmarkUpdater::class],
            $this->container[UpdateBookmarkValidator::class],
            $this->container[BookmarkUpdaterValidator::class],
            $this->container[ViolationCollector::class],
            $this->container[ValueObjectFactory::class],
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
