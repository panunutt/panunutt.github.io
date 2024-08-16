<?php

date_default_timezone_set('Asia/Bangkok');
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
@ini_set('display_errors', '0');

include("resize-class.php");

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else {

    $file = $_FILES['file']['tmp_name'];

    correctImageOrientation($file);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.aiforthai.in.th/facedetect-w-wo-mask',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 1,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file' => new CURLFILE($file)),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: multipart/form-data',
            'Apikey: 9ir5JCtVKvp2WDvoKPHmgzaVNfrZmVX5'
        )
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {

        if ($response) {

            $filename = $_FILES['file']['name'];

            if (file_exists($filename)) {
                chmod($filename, 0755);
                unlink($filename);
            }

            $respons_decode = json_decode($response, true);
            $position = $respons_decode['objects'][0]["bbox"];

            $img = imagecreatefromjpeg($file);

            $color = imagecolorallocate($img, 255, 0, 0);

            imagerectangle($img, $position['xLeftTop'], $position['yLeftTop'], $position['xRightBottom'], $position['yRightBottom'], $color);

            imagejpeg($img, "../img/imgFace/" . $filename);

            echo $filename;
        } else {
            echo "ไม่พบใบหน้า";
        }
    }
}

function imageResize($imageResourceId, $width, $height)
{
    $targetWidth = $width < 400 ? $width : 500;
    $targetHeight = ($height / $width) * $targetWidth;
    $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
    return $targetLayer;
}

function correctImageOrientation($filename)
{
    if (function_exists('exif_read_data')) {
        $exif = exif_read_data($filename);
        if ($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if ($orientation != 1) {
                $sourceProperties = getimagesize($filename);
                $img = imagecreatefromjpeg($filename);
                $deg = 0;
                switch ($orientation) {
                    case 3:
                        $deg = 180;
                        break;
                    case 6:
                        $deg = 270;
                        break;
                    case 8:
                        $deg = 90;
                        break;
                }
                if ($deg) {
                    $img = imagerotate($img, $deg, 0);
                }
                $img = imageResize($img, $sourceProperties[0], $sourceProperties[1]);
                imagejpeg($img, $filename, 95);
            }
        }
    }
}
