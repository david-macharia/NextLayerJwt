<?php


namespace Davidkiarie\NextLayerJwtPackage\Tools;

use App\Rules\UserIdExistInEitherTable;
use Carbon\Carbon;
use Davidkiarie\NextLayerJwtPackage\VendorSrc\JWT;
use Nette\Utils\Random;

trait CreateJwt
{

  public function createJwt($payload)
  {
    $key = env("JWT_SECRET");
    $payload = array_merge($payload, [

      "token_id" => Random::generate(),
      "iat" => Carbon::now()->timestamp,
      "exp" => Carbon::now()->addHour()->timestamp,
    ]);
  
    return JWT::encode($payload, $key, 'HS256');
  }
  public function createRefreshJwt($payload)
  {
    $key = env("JWT_SECRET");
    $payload = array_merge($payload, [
      "token_type" => "refreshToken",

      "token_id" => Random::generate(),
      "iat" => Carbon::now()->timestamp,
      "exp" => Carbon::now()->addYear()->timestamp,

    ]);
    return JWT::encode(
      array_merge($payload, ["token_type" => "refreshToken"]),
      $key,
      'HS256'
    );
  }
}
