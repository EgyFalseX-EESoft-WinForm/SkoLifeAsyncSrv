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
	"1",
	[
		[
			"Yousra Ayman Abdelmaree \'Abd Al - Jaid Hussein",
			20,
			11,
			1,
			1,
			"يسرا عبدالمرضى ايمن اللقب",
			"Yousra Ayman Abdelmaree \'Abd Al - Jaid Hussein",
			"2006-06-25",
			"عنوان الطالب - منطقة - شارع - اقامة",
			"01150888088",
			"01150888088"
		]
	],
	[
		{
			"dyn_order": 1,
			"op_col_name": "edit_date",
			"op_col_value": "2019092812",
			"update_query": "SELECT FORMAT(GETDATE(), ) AS edit_date"
		}
	]
]';

$oppost = new OpPost($db, $data);

echo json_encode(array('message' => 'Success'));


