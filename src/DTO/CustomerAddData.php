<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *     request="customerAdd",
 *     required=true,
 *     @OA\JsonContent(
 *      required={"username", "password", "telephone", "email"},
 *      @OA\Property(type="string", property="username"),
 *      @OA\Property(type="string", property="password"),
 *      @OA\Property(type="string", property="telephone"),
 *      @OA\Property(type="string", property="email"),
 * )
 * )
 */
class CustomerAddData
{

}
