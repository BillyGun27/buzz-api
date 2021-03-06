<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Database\DBConnect;
use \Firebase\JWT\JWT;

class BuzzController extends BaseController
{
    protected $db;

    
   // constructor receives container instance
   public function __construct($db) {
    $this->db = $db;
   }


    public function view($request, $response, $args) {
       // if($args['who']="all"){
            $stmt = $this->db->query("SELECT * FROM user");
            //SELECT * ,IF(qna.follow.id = 2 , "true" , "false" ) AS checkmark FROM qna.user LEFT JOIN (SELECT * FROM qna.follow WHERE  qna.follow.user = 2 ) AS follow ON qna.user.id =  qna.follow.followed  WHERE qna.user.id != 2 ;
     //   }else{
            //SELECT * ,IF(qna.follow.id = 2 , "true" , "false" ) AS checkmark FROM qna.user JOIN (SELECT * FROM qna.follow WHERE  qna.follow.user = 2 ) AS follow ON qna.user.id =  qna.follow.followed  WHERE qna.user.id != 2 ;
      //  }
           
        return $response->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')->withJson($stmt->view());
    }

    //count follower

    public function follow($request, $response, $args){
        /*$stmt = $this->db->query("INSERT INTO tb_donasi (tb_kotak_id_kotak,tb_barang_id_barang,jumlah) VALUES (?,?,?) ")
         ->param( [ $args['kotak'], $args['barang'], $args['jumlah'] ] );
        */
        //SELECT * , COUNT(qna.follow.user) AS total FROM qna.follow GROUP BY followed; 
        //SELECT  COUNT(qna.follow.user) AS total FROM qna.follow WHERE followed=? GROUP BY followed ; 

        //UPDATE user SET follower = ( SELECT  COUNT(qna.follow.user) AS total FROM qna.follow WHERE followed=? GROUP BY followed ) WHERE id = ? 
         
        //return $response->withJson($stmt->send()) ;//$args['kotak'].$args['barang'].$args['jumlah'];
        $stmt = $this->db->query("SELECT * FROM buzz.follow JOIN buzz.user ON buzz.user.id = buzz.follow.following WHERE buzz.follow.user = ?; ")
        ->param( [ $args['id'] ]);

        return $response->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')->withJson($stmt->view());

    }

    public function followuser($request, $response, $args) {
        //$data = $request->getParsedBody();
        $userid =  $args['userid'];//$data["userid"];
        $followid =  $args['followid'];//$data["followid"];

        $stmt = $this->db->query("INSERT INTO follow (user, following ) VALUES (?,?)")
        ->param([ $userid, $followid ]);
     
        if( $stmt->send()){
            return $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')->withJson("Followed");
        }else{
            return $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')->withJson("Connection Error");
        }
        
    }

    public function checkfollow($request, $response, $args){
        $userid =  $args['userid'];//$data["userid"];
        $followid =  $args['followid'];//$data["followid"];

        $stmt = $this->db->query("SELECT * FROM follow WHERE user = ? AND following = ? ")
        ->param( [ $userid, $followid ]);

        if( empty( $stmt->view() ) ){
            $result = false;
        }else{
            $result = true;
        }
        return $response->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')->withJson($result);

    }

  
    
}
