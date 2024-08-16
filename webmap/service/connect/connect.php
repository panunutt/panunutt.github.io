<?php

date_default_timezone_set('Asia/Bangkok');
@ini_set('display_errors', '0');

//$connect = mysqli_connect('sql204.infinityfree.com:3306','if0_36563937','vL6ecbGl4A','if0_36563937_dbmap');
$connect = mysqli_connect('localhost','id22187357_admin','Dbmap#12345','id22187357_dbmap');
mysqli_set_charset($connect,'utf8');

	// Check connection
	if (mysqli_connect_errno())
		{
		echo 'Database Connect Failed : ' . mysqli_connect_error();
		}

?>