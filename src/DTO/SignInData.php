<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *     request="signin",
 *     required=true,
 *     @OA\JsonContent(
 *      required={"username", "password", "email"},
 *      @OA\Property(type="string", property="username"),
 *      @OA\Property(type="string", property="password"),
 *      @OA\Property(type="string", property="email"),
 * )
 * )
 */
class SignInData
{

}
