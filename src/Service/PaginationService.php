<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaginationService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPagination(int $page, int $count): array
    {
        $currentPage = $page;
        $limit = 10;
        $pages = ceil($count / $limit);
        $offset = $limit * ($currentPage - 1);

        if ($currentPage <= 0 || $currentPage > $pages || !filter_var($page, FILTER_VALIDATE_INT)) {
            throw new BadRequestHttpException('This page doesn\'t exist.'.' (only '.$pages.' pages)');
        }

        return [
            'limit' => $limit,
            'offset' => $offset,
        ];
    }
}
