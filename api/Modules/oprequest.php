<?php
// Insert the path where you unpacked log4php
    include_once('../../log4php/Logger.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetConfig
 *
 * @author FalseXDev
 */
class OpRequest {
    /** Holds the Logger. */
    private $log;
    
    private $config_conn;
    private $op_id;
    private $select_sql;
    public $dataarr;
    //private $dataarr;
    //private $dynarr;
    
    private $op_con;
    //private $op_dst_tbl;
    //private $op_dst_col;
    //private $col_namearr;
    //private $col_convarr;
    
    // constructor with $db as database connection
    public function __construct($db, $data){
        // Fetch a logger, it will inherit settings from the root logger
        $this->log = Logger::getLogger(__CLASS__);
        
        $this->config_conn = $db;
        $arr = json_decode($data, true);
        $this->op_id = array_values($arr)[0];
        $this->select_sql = array_values($arr)[1];
        //$this->dataarr = $arr[1];
        //$this->dynarr = $arr[2];
        $this->Perpare();
        $this->GetData();
    }
    
    public function Perpare() {
        
        try {
            $query = "SELECT con.op_host, con.op_db_name, con.op_username, con.op_password FROM op_config INNER JOIN op_connection con ON op_config.op_con_id = con.op_con_id WHERE op_id = :op_id";
            $result = $this->config_conn->prepare($query);
            $result->bindParam(':op_id', $this->op_id);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            //Instantiate DB & connect
            $database = new Database();
            $this->op_con = $database->getConnection($row["op_host"], $row["op_db_name"], $row["op_username"], $row["op_password"]);
        }
        catch (exception $ex) {
            $this->log->error("OP ".$op.": ".$ex-> getMessage());
        }
    }
    
    public function GetData() {
        
        try {
            $this->dataarr = array();
            
            //get conv info from database
            $query = $this->select_sql;
            $result = $this->op_con->prepare($query);
            $result->execute();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                array_push($this->dataarr,$row);
            }
        }
        catch (exception $ex) {
            $this->log->error("OP ".$op.": ".$ex-> getMessage());
        }
    }
}
