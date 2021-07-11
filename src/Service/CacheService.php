<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class CacheService
{

    public function cache(Response $response): Response
    {
        $response->setPublic();
        $response->setMaxAge(3600);

        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

}
