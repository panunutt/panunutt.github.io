<?php
session_start();

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	$data = array();
	require('connect/connect.php');


	if ($_POST['act']=='A'){
		$objQuery = mysqli_query($connect,"INSERT INTO pin_tb (lat,lng,detail,path,rate,byname) VALUES('".$_POST['lat']."','".$_POST['lng']."','".$_POST['detail']."','','','')");
	}


	if ($_POST['act']=='D'){
		$objQuery = mysqli_query($connect,"DELETE FROM  pin_tb WHERE id = '".$_POST['id']."'");
	}
	
	if ($_POST['act']=='E'){
		
		$objQuery = mysqli_query($connect,"UPDATE pin_tb SET lat='".$_POST['lat']."',lng='".$_POST['lng']."',detail='".$_POST['detail']."' WHERE id = '".$_POST['id']."'");
	}
	
	
	
	
	if ($objQuery){
		array_push($data, array('result' => 'T'));
	}else{
		array_push($data, array('result' => 'F'));
	}

	//array_push($data, array('sql' => "UPDATE member SET permission='".$_POST['erule']."' WHERE uid = '".$_POST['e_uid']."'"));
	
	
	
	mysqli_close($connect);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($data);	

 
 

?>