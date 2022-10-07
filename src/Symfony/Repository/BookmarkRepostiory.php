<?php

namespace App\Symfony\Repository;

use App\Domain\Bookmark\Model\Bookmark;
use App\Domain\Bookmark\Repository\BookmarkRepository as DomainBookmarkRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookmarkRepostiory extends ServiceEntityRepository implements DomainBookmarkRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }

    public function findById(int $id): ?Bookmark
    {
        return $this->find($id);
    }

    public function persist(Bookmark $bookmark): void
    {
        $this->getEntityManager()->persist($bookmark);
        $this->getEntityManager()->flush();
    }
}
