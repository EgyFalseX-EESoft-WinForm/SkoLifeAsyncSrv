<?php
    // Insert the path where you unpacked log4php
    include_once('../../log4php/Logger.php');
    
class Database{
    /** Holds the Logger. */
    private $log;
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "skolifeasync";
    private $username = "root";
    private $password = "";
    public $conn;
 
    public function __construct(){
        // Tell log4php to use our configuration file.
        Logger::configure('../../loggingconfiguration.xml');
        // Fetch a logger, it will inherit settings from the root logger
        $this->log = Logger::getLogger(__CLASS__);
    }
    // get the database connection
    public function getConfigConnection(){
        
        set_time_limit(3600);
        
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            //$this->conn->setAttribute(PDO:ATTR_ERR)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            $this->log->error($exception->getMessage());
            }
 
        return $this->conn;
    }
    
    public function getConnection($host, $db_name, $username, $password){
        
        set_time_limit(3600);
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            $this->log->error($exception->getMessage());
        }
 
        return $this->conn;
    }
}
?>