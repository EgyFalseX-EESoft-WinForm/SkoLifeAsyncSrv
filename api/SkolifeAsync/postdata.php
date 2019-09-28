<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,'
        . 'Access-Control-Allow-Methods, Authorization, X-Requested-With');
//includes
include_once '../config/database.php';
include_once '../Modules/oppost.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->getConfigConnection();

// Get row posted data
$data = array();
$data = file_get_contents("php://input");

//$data = '';

$oppost = new OpPost($db, $data);

echo json_encode(array('message' => 'Success'));


