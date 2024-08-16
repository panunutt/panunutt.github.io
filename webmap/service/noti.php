<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//set_time_limit(0);
//ini_set('max_input_time ', 1000);


header('Content-Type: application/json; charset=utf-8');
//error_reporting(~E_NOTICE ^ E_WARNING);
//@ini_set('display_errors', '1'); //แสดงerror
@ini_set('display_errors', '0'); //ไม่แสดงerror
date_default_timezone_set('Asia/Bangkok');


    $date = date('Y-m-d');

	try {

		$pic =  "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";

		$str = "test";
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



// define('LINE_API', "https://notify-api.line.me/api/notify");

// function notify_message($message, $token)
// {
//     $queryData = array('message' => $message);
//     $queryData = http_build_query($queryData, '', '&');
//     $headerOptions = array(
//         'http' => array(
//             'method' => 'POST',
//             'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
//                 . "Authorization: Bearer " . $token . "\r\n"
//                 . "Content-Length: " . strlen($queryData) . "\r\n",
//             'content' => $queryData
//         ),
//     );
//     $context = stream_context_create($headerOptions);
//     $result = file_get_contents(LINE_API, FALSE, $context);
//     $res = json_decode($result);
//     return $res;
// }




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