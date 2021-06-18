<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\SecurityScheme(
 *      in="header",
 *      name="Authorization",
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class SecuritySchemes
{
}
