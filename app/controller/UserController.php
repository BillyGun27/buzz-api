<?php
namespace App\Controller;

use Slim\Http\UploadedFile;

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

public function profile($request, $response, $args){
    
    $directory = __DIR__ . '/../../profile/uploads';
    $uploadedFiles = $request->getUploadedFiles();

    // handle single input with single file upload
    $uploadedFile = $uploadedFiles['profile'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = $this->moveUploadedFile($directory, $uploadedFile);
        return "success get";//$response->write('success');
    }else{
        return "error";//$response->write('error try again');
    }

}

public function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = "coba";//bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

public function update($request, $response, $args){
    $data = $request->getParsedBody();
    $id = $data["id"];
    $email = $data["email"];
    $name = $data["name"];
    $job = $data["job"];
    $youtube = $data["youtube"];
    $instagram = $data["instagram"];
    $facebook = $data["facebook"];
    $twitter = $data["twitter"];
    $phone = $data["phone"];
    $bio = $data["bio"];
    $follower = $data["follower"];
    $price = $data["price"];

    $stmt = $this->db->query("UPDATE user SET email = ?,name =?, job = ?,youtube = ?,instagram= ?,facebook=?,twitter=?,phone=?,bio=?,follower=?,price=?  WHERE id = ? ")
    ->param([$email,$name,$job,$youtube,$instagram,$facebook,$twitter,$phone,$bio,$follower,$price ,$id ]);
    $stmt->send();
    return $response->withJson( $name );
}



public function register($request, $response, $args) {
        $data = $request->getParsedBody();
        $email = $data["email"];
        $name = $data["name"];
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
        $status = $data["status"];
        $stmt = $this->db->query("INSERT INTO user (email,name, password, status ) VALUES (?,?,?,?)")->param([ $email ,$name,$password,$status ]);
     
        if( $stmt->send()){
            return $response->withJson("succes");
        }else{
            return $response->withJson("User Already Exist");
        }
        
    }


    
}
