<?php

session_start();

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
require('connect/connect.php');

	$objQuery = mysqli_query($connect,"SELECT * FROM pin_tb where 1");
	//$result = mysqli_fetch_array($objQuery);
	$data = array();
	if ($objQuery){
		while($result = mysqli_fetch_assoc($objQuery))
		{
			array_push($data, array(
						'id' => $result['id'],
						'lat' => $result['lat'],	
						'lng' => $result['lng'],	

						'detail' => $result['detail'],	

						'path' => $result['path'],	
						'rate' => $result['rate'],	
						'by_name' => $result['by_name'],
						'datetime' => $result['datetime']
						)
			);
		}
	}
	mysqli_close($connect);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data);	
 
 

?>