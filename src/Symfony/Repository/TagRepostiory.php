<?php

namespace App\Symfony\Repository;

use App\Domain\Bookmark\Model\Tag;
use App\Domain\Bookmark\Repository\TagRepository as DomainTagRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TagRepostiory extends ServiceEntityRepository implements DomainTagRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findByTitle(string $title): ?Tag
    {
        return $this->findOneBy(['title' => $title]);
    }
}
