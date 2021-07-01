<?php

namespace App\ApiInfo;

/**
 * @OA\RequestBody(
 *     request="login",
 *     required=true,
 *     @OA\JsonContent(
 *      required={"username", "password"},
 *      @OA\Property(type="string", property="username"),
 *      @OA\Property(type="string", property="password")
 * )
 * )
 */
class LoginData
{

}
