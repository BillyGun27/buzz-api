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


    public function viewdata($request, $response, $args) {
       // $jwt = $request->getHeader("Auth-Key");
       // $token = $this->CheckToken($jwt[0]);
        $stmt = $this->db->query("SELECT * FROM tb_barang");
       // ->param( [$token->id] );
        //return $response->withJson( $request->getParsedBody() );//$response->withJson( $stmt->view() );
        return $response->withJson($stmt->view());
     //   return $response->withJson($token);
    }

    public function viewdonasi($request, $response, $args) {
        // $jwt = $request->getHeader("Auth-Key");
        // $token = $this->CheckToken($jwt[0]);
         $stmt = $this->db->query("SELECT * FROM tb_donasi");
        // ->param( [$token->id] );
         //return $response->withJson( $request->getParsedBody() );//$response->withJson( $stmt->view() );
         return $response->withJson($stmt->view());
      //   return $response->withJson($token);
     }

    public function insert($request, $response, $args){
        $stmt = $this->db->query("INSERT INTO tb_donasi (tb_kotak_id_kotak,tb_barang_id_barang,jumlah) VALUES (?,?,?) ")
         ->param( [ $args['kotak'], $args['barang'], $args['jumlah'] ] );
        return $response->withJson($stmt->send()) ;//$args['kotak'].$args['barang'].$args['jumlah'];
    }

    public function capacity($request, $response, $args){
        $stmt = $this->db->query("UPDATE tb_kotak SET kapasitas = (?) WHERE id_kotak = ? ")
         ->param( [ $args['percent'], $args['kotak'] ] );
        return  $response->withJson($stmt->send()) ;//$args['percent']. $args['kotak'];//
    }
    
}
