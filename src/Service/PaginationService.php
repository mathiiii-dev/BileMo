<?php

namespace App\Service;

class PaginationService
{
    public function getPagination(int $page, int $count): array
    {
        $currentPage = $page;
        $limit = 10;
        $pages = ceil($count / $limit);
        $offset = $limit * ($currentPage - 1);

        return [
            'limit' => $limit,
            'offset' => $offset,
            'pages' => $pages,
            'currentPage' => $currentPage,
        ];
    }
}
