<?php
namespace Davidkiarie\NextLayerJwtPackage\Models;
class GlobalUser{
    public  $user_type;
    public $user_id;
    public $query;
    public function isClient():bool{
        if($this->user_type=="client"){
            return true;
        }
        return false;

    }
    public function isMerchant():bool{
        if($this->user_type=="merchant"){
           return true;
        }
        return false;
    }
}