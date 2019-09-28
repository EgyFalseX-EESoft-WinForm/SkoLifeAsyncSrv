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
include_once '../config/database.php';
include_once '../Modules/opconfig.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->getConfigConnection();

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
        
        $op_item = array(
            'op_id' => $op_id,
            'op_order' => $op_order,
            'op_desc' => $op_desc,
            'sql_query' => $sql_query,
            'op_src_filter' => $op_src_filter,
            'dyn_list' => $listDyn
                );
        //Push to $return_arr['data']
        array_push($return_arr, $op_item);
    }
    //Convert to JSON
    echo json_encode($return_arr);
}
else
{
    // No Data
    echo json_encode(
            array('message' => 'No Data found')
            );
}
