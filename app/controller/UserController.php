<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Database\DBConnect;
use \Firebase\JWT\JWT;

class UserController extends BaseController
{
    protected $db;

    
   // constructor receives container instance
   public function __construct($db) {
    $this->db = $db;
   }


public function login($request, $response, $args) {
        //$response->headers->set('Auth-Key', 'dasdsad342q3');
        //$response->withHeader('Auth-Key', 'ihlkhklj');
        $data = $request->getParsedBody();
        $email = $data["email"];
        $password = $data["password"];
        
        $stmt = $this->db->query("SELECT id,email,password FROM user WHERE email=? ")->param([ $email ]);

        $user = $stmt->view()  ;
        $access= password_verify ( $password , $user[0]["password"] );
        $coba = password_hash('famous', PASSWORD_DEFAULT);
        $stmt = $this->db->query("SELECT * FROM user WHERE id = ?")
        ->param( [$user[0]["id"]] );

        $profile =  $stmt->view()  ;

            if($access){
            
                $jwt = $this->MakeToken($user[0],$profile);
                
                $fields = array(
                    "id" => $user[0]["id"],
                    "email" => $user[0]["email"],
                    "profile" => $profile,
                    "token" => $jwt,
                );


                return $response->withJson($fields); 
            }else{
                return $response->withJson("User Not Found"); 
            }
   

    }

public function update($request, $response, $args){
    $data = $request->getParsedBody();
    $id = $data["id"];
    $email = $data["email"];
    $name=$data["name"];
    $job = $data["job"];
    $youtube = $data["youtube"];
    $instagram = $data["instagram"];
    $facebook = $data["facebook"];
    $twitter = $data["twitter"];
    $phone = $data["phone"];
    $bio = $data["bio"];
    

    $stmt = $this->db->query("UPDATE user SET job = ?,instagram= ?  WHERE id = ? ")->param([$job,$instagram ,$id ]);
 
    return $response->withJson( $stmt->send() );
}

public function register($request, $response, $args) {
        $data = $request->getParsedBody();
        $email = $data["email"];
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
        $stmt = $this->db->query("INSERT INTO user (email, password ) VALUES (?,?)")->param([ $email ,$password ]);
     
        if( $stmt->send()){
            return $response->withJson("succes");
        }else{
            return $response->withJson("User Already Exist");
        }
        
    }
    
    
}
