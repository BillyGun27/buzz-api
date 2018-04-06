<?php
namespace App\Database;

class DB
{
    private $conn;
    private $data = array();
    private $query;
    private $param;

    /**
     * build
     * 
     * @return object
     */
    public function  __construct() {
      //  $this->conn = (new DBConnect)->conn;
      if(!$this->conn){
  /*      $dsn = 
            _CONFIG_['db']['driver'].
            ":port=" . _CONFIG_['db']['port'].
            ":host=" . _CONFIG_['db']['host'].
            ";dbname=" . _CONFIG_['db']['dbname']
        ;
*/
$servername = _CONFIG_['db']['host'];
$username = _CONFIG_['db']['username'];
$password = _CONFIG_['db']['password'];
$dbname = _CONFIG_['db']['dbname'];
$port = _CONFIG_['db']['port'];
        try{
            $this->conn = new \PDO( _CONFIG_['db']['driver'].":host=$servername;port=$port;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
        }
    }

    public function close(){
        $this->conn = null;
    }

    public function query($data){
        $this->query = $data;
        return $this;
    }

    public function param($data){
        $this->param = (array) $data;
        return $this;
    }

    private function process(){
        $stmt = null;
        try {
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute((array) $this->param);    
        } catch (\PDOException $e) {
           // echo $e->getMessage()."<br>";
           // throw new \Exception();
           $stmt = false;
        }

        return $stmt;
    }

    public function view(){
        $stmt = $this->process();

        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function send(){
        $stmt = $this->process();
        $success = false;
        if($stmt){
            $success = true;
        }
        return $success;
    }



    

 

}