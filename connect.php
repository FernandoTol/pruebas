<?php
$connection = mysqli_connect('localhost', 'kodids', '20KodidS16');
if (!$connection){
    $db_connection = "False";	
    die("Database Connection Failed" . mysqli_error($connection));
}else{
	$db_connection = "True";

}
$select_db = mysqli_select_db($connection, 'kodiDS');
if (!$select_db){
    $db_select = "False";
    die("Database Selection Failed" . mysqli_error($connection));
}else{
	$db_select = "True";
}


if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }elseif (isset($_SERVER['HTTP_VIA'])) { $ip = $_SERVER['HTTP_VIA']; }elseif (isset($_SERVER['REMOTE_ADDR'])) { $ip = $_SERVER['REMOTE_ADDR']; }else { $ip = "Desconocido"; }session_start();if(!$_SESSION['username']){$webU = "NoLoged";}else{$webU=$_SESSION['username'];}
$fp_op = fopen("../dashboard/mysql_history.log", "a+");
fputs($fp_op,"DB=" . $db_connection . "&WebUser:" . $webU. "IP=" . $ip . "&Agent=".$_SERVER['HTTP_USER_AGENT']."&D:".date("y-m-d H:i:s")."\n");
fclose($fp_op);


$mysql_hostname = "localhost";
$mysql_user     = "kodids";
$mysql_password = "20KodidS16";
$mysql_database = "kodiDS";
$bd             = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Oops some thing went wrong");
