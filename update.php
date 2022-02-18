<?php
session_start();
if (!$_SESSION['username']) {
   header("location:../../");
   die;
}

include('./includes/connect.php');
include('./includes/path.php');
include('./includes/navigation.php');


$mac = $_GET["mac"];
$result = $mysqli->query("SELECT * FROM `pds_MarcadorF`  WHERE ($mac)" );
$row = $result->fetch_row();

echo json_encode(['marcador'=>$row[0]]);

echo $result
?>