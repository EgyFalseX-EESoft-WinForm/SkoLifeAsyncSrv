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
class OpUpdateDyn {
    /** Holds the Logger. */
    private $log;
    
    private $config_conn;
    private $op_id;
    private $dynarr;
    
    // constructor with $db as database connection
    public function __construct($db, $data){
        // Fetch a logger, it will inherit settings from the root logger
        $this->log = Logger::getLogger(__CLASS__);
        
        $this->config_conn = $db;
        $arr = json_decode($data, true);
        $this->op_id = array_values($arr)[0];
        $this->dynarr = array_values($arr)[1];
        $this->UpdateDyn();
    }
    
    public function UpdateDyn() {
        
         try {
             
             foreach ($this->dynarr as $item) 
            {
                extract($item);
                $query = "update op_dyn set op_col_value = :op_col_value where op_id = :op_id and op_col_name = :op_col_name";
                $result = $this->config_conn->prepare($query);
                $result->bindParam(":op_col_value", $op_col_value);
                $result->bindParam(":op_id", $this->op_id);
                $result->bindParam(":op_col_name", $op_col_name);
                $result->execute();
            }
         } catch (Exception $ex) {
             $this->log->error("OP ".$op.": ".$ex-> getMessage());
         }
    }
}
