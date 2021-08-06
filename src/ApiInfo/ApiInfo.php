<?php

namespace App\ApiInfo;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Bilemo API", version="0.3")
 * @OA\Server(
 *     url="https://127.0.0.1:8000/api",
 *     description="dev"
 * )
 * @OA\Server(
 *     url="https://api-bilemo.herokuapp.com/api",
 *     description="prod"
 * )
 */
class ApiInfo
{

}
