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
class OpConfig {
    /** Holds the Logger. */
    private $log;
    // database connection and table name
    private $conn;
    
    // constructor with $db as database connection
    public function __construct($db){
        // Tell log4php to use our configuration file.
        Logger::configure('../../loggingconfiguration.xml');
        // Fetch a logger, it will inherit settings from the root logger
        $this->log = Logger::getLogger(__CLASS__);
        
        $this->conn = $db;
    }
    public function OpConfigData(){
        try{
            $query = "SELECT
                op_config.op_id,
                op_config.op_order,
                op_config.op_desc,
                op_connection.op_connection AS src_con,
                op_src_filter,
                CONCAT('SELECT ', op_src_col, ' FROM ', op_src_tbl) AS sql_query
              FROM op_config
                INNER JOIN op_connection
                  ON op_config.op_con_id = op_connection.op_con_id
                WHERE enable = TRUE";
            
            // prepare query
            $result = $this->conn->prepare($query);
            $success = $result->execute();
            if (!$success) {
                $this->log->error($result->errorInfo());
            }
            
            return $result;
            
        } catch (Exception $ex) {
            $this->log->error($ex->getMessage());
        }
    }
    public function OpConfigDyn($op){
        try{
            $query = "SELECT op_order as dyn_order,op_col_name,op_col_value,update_query FROM op_dyn WHERE op_id = ".$op;
            // prepare query
            $result = $this->conn->prepare($query);
            $success = $result->execute();
            if (!$success) {
                $this->log->error($result->errorInfo());
            }
            
            return $result;
        
        } catch (Exception $ex) {
            $this->log->error($ex->getMessage());
        }
        
    }
    
}
