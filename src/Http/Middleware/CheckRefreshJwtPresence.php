<?php

namespace Davidkiarie\NextLayerJwtPackage\Http\Middleware;

require dirname(__DIR__, 3). '/vendor/autoload.php';

use Carbon\Carbon;
use Davidkiarie\NextLayerJwtPackage\VendorSrc\ExpiredException;
use Davidkiarie\NextLayerJwtPackage\VendorSrc\JWT;
use Davidkiarie\NextLayerJwtPackage\VendorSrc\Key;
use Davidkiarie\NextLayerJwtPackage\VendorSrc\SignatureInvalidException;

use Closure;
use Davidkiarie\NextLayerJwtPackage\Tools\CreateJwt;
use Exception;
use Illuminate\Http\Request;

class CheckRefreshJwtPresence
{
    
    use CreateJwt;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {  





        $key = env("JWT_SECRET");

       
        
        $token = $request->header("Authorization");
        if (!isset($token)) {
            return response()->json(["message" => "Please provide Authorisation  Bearer token  Header"], 401);
        } else {
            $data = explode(" ", $token);
            if (count($data) != 2) {
                return response()->json(["message" => "Please provide Authorisation  Bearer token  Header"], 401);
            } else {
                if ($data[0] != "Bearer") {
                    return response()->json(["message" => "Please provide Authorisation  Bearer token  Header"], 401);
                } else {
                    $jwt = $data[1];
                    try {
                        
                        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
                         if($decoded->token_type!="refreshToken"){
                             return response()->json(["message"=>"Unknown Token ,please provide a refreshToken"],422);
                         }else{
                             if(!isset( $decoded->user_type)||!isset( $decoded->user_id) ){
                                return response()->json(["message"=>"Could not parse claims [user_id] [user_type]"],422);

                             }
                            $paload=[
                                "token_type"=>"Bearer",
                                "token_id"=>rand(),
                                "iat"=>Carbon::now()->timestamp,
                                "exp"=> Carbon::now()->addHour()->timestamp,
                                "user_type"=> $decoded->user_type,
                                "user_id"=>$decoded->user_id,
                              ];
                              $jwt=$this->createJwt( $paload);
                              return response()->json(["accessToken" =>   $jwt], 200);
                         }
                          return response()->json($decoded);
                        
                    } catch (ExpiredException $e) {
                        
                        return response()->json(["Message" => "Refresh Token Expired"], 498);
                    } catch (SignatureInvalidException $e) {
                        return response()->json(["Message" => "Invalid Signature Detected"], 401);
                    } catch (Exception $e) {
                        return response()->json(["Message" => "Could not verify request"], 401);
                    }


                    // $decoded= JWT::encode($k, $key, 'HS256');

                    // return response()->json( $decoded,200);

                }
            }
        }






        // parent::handle($request,$next);

          
        
    }
}
