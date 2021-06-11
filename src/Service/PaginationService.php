<?php

namespace App\Service;

class PaginationService
{
    public function getPagination($page)
    {
        $currentPage = $page ?? 1;
        $limit = 10;
        $offset = $limit * ($currentPage - 1);

        return [
            "limit" => $limit,
            "offset" => $offset
        ];
    }
}
