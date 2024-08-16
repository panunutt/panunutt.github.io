<?php

session_start();


header('Content-Type: application/json; charset=utf-8');
//error_reporting(~E_NOTICE ^ E_WARNING);
//@ini_set('display_errors', '1'); //แสดงerror
@ini_set('display_errors', '0'); //ไม่แสดงerror
date_default_timezone_set('Asia/Bangkok');

$type = $_REQUEST['type'];
$detail= $_REQUEST['detail'];

    $date = date('Y-m-d');

	try {

		$pic =  "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";

		$str = $detail.' ('.$type/')';
		$res['nut'] =  send('BUQrcHWLICeKKT3DidE4xMIt281rZx6kX9DarMR8H01', $str, $pic);

        $response = [
            'result' => [
                //'status' => true,
                'status' => $res,
            ],
        ];
        echo json_encode($response);

	} catch (Exception $e) {
		print_r($e->getMessage());
	}




function send($token, $msg, $img)
{

    define('LINE_API_URI', 'https://notify-api.line.me/api/notify');

    $headers = [
        'Authorization: Bearer ' . $token
    ];
    // $fields = [
    //     'message' => $msg
    // ];

    $imageFile = new CURLFILE($img);

    $data = array(
        
        'imageFile' => $imageFile,
        'message' => $msg,
    );

    try {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, LINE_API_URI);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $res = curl_exec($ch);
        curl_close($ch);

        if ($res == false)
            throw new Exception(curl_error($ch), curl_errno($ch));

        $json = json_decode($res);
        $status = $json->status;

        var_dump($status);
        return $status;
    } catch (Exception $e) {
        var_dump($e);
    }
}


?>