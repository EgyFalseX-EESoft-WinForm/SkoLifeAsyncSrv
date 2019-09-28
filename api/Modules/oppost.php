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
class OpPost {
    /** Holds the Logger. */
    private $log;
    
    private $config_conn;
    private $op_id;
    private $dataarr;
    private $dynarr;
    
    private $op_con;
    private $op_dst_tbl;
    private $op_dst_col;
    private $col_namearr;
    private $col_convarr;
    
    // constructor with $db as database connection
    public function __construct($db, $data){
        // Fetch a logger, it will inherit settings from the root logger
        $this->log = Logger::getLogger(__CLASS__);
        
        $this->config_conn = $db;
        $arr = json_decode($data, true);
        $this->op_id = $arr[0];
        $this->dataarr = $arr[1];
        $this->dynarr = $arr[2];
        
        $this->Perpare();
        $this->Merge();
        $this->UpdateDyn();
    }
    
    public function Perpare() {
        
        try {
            $query = "SELECT op_dst_tbl,op_dst_col, con.op_host, con.op_db_name, con.op_username, con.op_password FROM op_config INNER JOIN op_connection con ON op_config.op_con_id = con.op_con_id WHERE op_id = :op_id";
            $result = $this->config_conn->prepare($query);
            $result->bindParam(':op_id', $this->op_id);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $this->op_dst_tbl = $row["op_dst_tbl"];
            $this->op_dst_col = $row["op_dst_col"];

            //Instantiate DB & connect
            $database = new Database();
            $this->op_con = $database->getConnection($row["op_host"], $row["op_db_name"], $row["op_username"], $row["op_password"]);

            //get conv info from database
            $query = "SELECT op_col_name,conversion FROM op_conv WHERE op_id = :op_id";
            $result = $this->config_conn->prepare($query);
            $result->bindParam(':op_id', $this->op_id);
            $result->execute();

            $this->col_namearr = array();
            $this->col_convarr = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                array_push($this->col_namearr,$row["op_col_name"]);
                array_push($this->col_convarr,$row["conversion"]);
            }
        }
        catch (exception $ex) {
            $this->log->error($ex->getMessage());
        }
    }
    
    public function Merge(){
        try {
            
            foreach ($this->dataarr as $item)
            {
                $query = "INSERT INTO ". $this->op_dst_tbl
                        . " ( ". implode(" , ",$this->col_namearr). " ) VALUES (";
                $i = 0;
                for($i = 0; $i < count($this->col_namearr); $i++) 
                {
                    $query = $query.':'.$i;
                    if ($i + 1 < count($this->col_namearr)) {
                        $query = $query.",";
                    }
                    else {
                        $query = $query.")";
                    }
                }
                //$cell = $item[$i];
                $i = 0;
                $query = $query." ON DUPLICATE KEY UPDATE ";
                for($i = 0; $i < count($this->col_namearr); $i++) 
                {
                    $query = $query.$this->col_namearr[$i]." = VALUES(".$this->col_namearr[$i].")";
                    if ($i + 1 < count($this->col_namearr)) {
                        $query = $query.",";
                    }
                    else {
                        $query = $query.";";
                    }
                }
                
                $result = $this->op_con->prepare($query);
                for($i = 0; $i < count($this->col_namearr); $i++) {
                    $result->bindParam(':'.$i, $item[$i]);
                }
                
                $result->execute();
            }
        }
        catch (exception $ex) {
            $this->log->error($ex->getMessage());
        }
    }
    
    public function UpdateDyn() {
        
         try {
             
             foreach ($this->dynarr as $item) 
            {
                extract($item);
                $query = "update op_dyn set op_col_value = :value where op_id = :op_id and op_col_name = :op_col_name";
                $result = $this->config_conn->prepare($query);
                $result->bindParam(":value", $op_col_value);
                $result->bindParam(":op_id", $this->op_id);
                $result->bindParam(":op_col_name", $op_col_name);
                $result->execute();
            }
         } catch (Exception $ex) {
             $this->log->error($ex->getMessage());
         }
    }
}
