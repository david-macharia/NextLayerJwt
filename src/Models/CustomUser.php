<?php
namespace Davidkiarie\NextLayerJwtPackage\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Davidkiarie\NextLayerJwtPackage\Models\GlobalUser;
class CustomUser{
    public static function loadGlobalUserwithValue($value){
        if(!isset($value)){
            return false;
         }
        
        
            $globalUser= new GlobalUser();
          $result=DB::table('merchants_data')->where('merchant_id','=',$value)->first();
           if(isset($result)){
             $globalUser->query=$result;
             $globalUser->user_id="$value";
             $globalUser->user_type="merchant";
            
               request()->global_user= $globalUser;
         
           return true;
           }
           $result=DB::table('client_data')->where('client_id','=',$value)->first();
           if(isset($result)){
             $globalUser->query=$result;
             $globalUser->user_id="$value";
             $globalUser->user_type="client";
             request()->global_user= $globalUser;
                
             
             return true;
             }
 
          return false;
    }
}
