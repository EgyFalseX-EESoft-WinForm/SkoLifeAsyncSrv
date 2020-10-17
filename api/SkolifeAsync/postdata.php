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
//$data = file_get_contents("php://input");

$data = '[
	"17",
	[
		[
			494026,
			20,
			31,
			3,
			1,
			"على على اسلام اللقب",
			"On the title of Islam",
			"2004-09-04",
			"عنوان الطالب - منطقة - شارع - اقامة",
			"01150888088",
			"01150888088",
			494026,
			null,
			"28307152104301",
			"30409042100854",
			"494026",
			"147056382",
			null,
			null,
			null,
			null,
			true,
			"/9j/4AAQSkZJRgABAgAAAQABAAD"
		]
	],
	[
		{
			"dyn_order": 1,
			"op_col_name": "edit_date",
			"op_col_value": "2020100213",
			"update_query": "SELECT FORMAT(GETDATE(), \'yyyyMMddHH\') AS edit_date"
		}
	]
]';

$oppost = new OpPost($db, $data);

echo json_encode(array('message' => 'Success'));


