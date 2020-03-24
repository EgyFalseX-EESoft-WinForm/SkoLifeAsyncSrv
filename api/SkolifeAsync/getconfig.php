<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//includes
include_once('../../log4php/Logger.php');
include_once '../config/database.php';
include_once '../Modules/opconfig.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->getConfigConnection();

// Fetch a logger, it will inherit settings from the root logger
$log = Logger::getLogger(__CLASS__);

//Get Op Config Data
$opconfig = new OpConfig($db);
$result = $opconfig->OpConfigData();
$num = $result->rowCount();
if ($num > 0) {
    $return_arr = array();
    //$return_arr['data'] = array();
    while($configRow = $result->fetch(PDO::FETCH_ASSOC))
    {
       extract($configRow);
       
       // Get Dyn Data
       $resultDyn = $opconfig->OpConfigDyn($op_id);
       $listDyn = array();
       while($dynRow = $resultDyn->fetch(PDO::FETCH_ASSOC))
       {
           extract($dynRow);
           $dyn_item = array(
            'dyn_order' => $dyn_order,
            'op_col_name' => $op_col_name,
            'op_col_value' => $op_col_value,
            'update_query' => $update_query,    
               );
           array_push($listDyn, $dyn_item);
       }
       
       // Get Key Data
       $resultKey = $opconfig->OpConfigKey($op_id);
       $listKey = array();
       while($KeyRow = $resultKey->fetch(PDO::FETCH_ASSOC))
       {
           extract($KeyRow);
           $Key_item = array(
            'op_src_col_name' => $op_src_col_name,
            'op_dst_col_name' => $op_dst_col_name   
               );
           array_push($listKey, $Key_item);
       }
        
        $op_item = array(
            'op_id' => $op_id,
            'op_order' => $op_order,
            'op_desc' => $op_desc,
            'op_dst_tbl' => $op_dst_tbl,
            'op_dst_col' => $op_dst_col,
            'sql_query' => $sql_query,
            'op_src_filter' => $op_src_filter,
            's2w' => $s2w,
            'dyn_list' => $listDyn,
            'key_list' => $listKey
                );
        //Push to $return_arr['data']
        array_push($return_arr, $op_item);
    }
    $log->info('Requested config return with '.count($return_arr).' rows');
    //Convert to JSON
    echo json_encode($return_arr);
}
else
{
    // No Data
    echo json_encode(
            array('message' => 'No Data found')
            );
    $log->info('Requested config return with No Data found');
}
