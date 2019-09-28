<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "skolifeasync";
    private $username = "root";
    private $password = "";
    public $conn;
 
    // get the database connection
    public function getConfigConnection(){
        
        set_time_limit(3600);
        
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            //$this->conn->setAttribute(PDO:ATTR_ERR)
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
    
    public function getConnection($host, $db_name, $username, $password){
        
        set_time_limit(3600);
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>