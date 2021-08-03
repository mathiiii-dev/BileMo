<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestParametersCheckService
{
    public function checkParamsProducts(Request $request): int
    {
        $page = $request->get('page');

        if (!$page) {
            $page = 1;
        }

        return $page;
    }

    public function checkParamsCustomers(Request $request): array
    {
        $id = $request->get('id');
        $page = $request->get('page');

        if (!$id) {
            throw new BadRequestHttpException('Missing parameter. id parameter is mandatory', null, 400);
        }

        if (!$page) {
            $page = 1;
        }

        return [
            'id' => $id,
            'page' => $page,
        ];
    }
}
