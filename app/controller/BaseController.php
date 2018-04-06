<?php
namespace App\Controller;

use App\Database\DBConnect;
use \Firebase\JWT\JWT;

class BaseController
{
    protected $key =  "secret_key";

    public function MakeToken($info,$farm) {
        $token = array(
            "url" => "localhost",
            "id"=>$info["id"],
            "email" =>$info["email"],
            "level" => $info["level"],
            "farm" => $farm
        );
        $jwt = JWT::encode($token, $this->key);
        return $jwt;
    }

    public function CheckToken($jwt){
       $token = JWT::decode($jwt, $this->key, array('HS256'));
       return $token;
    }

    
}
