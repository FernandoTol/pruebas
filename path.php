<?php
session_start();
if(!$_SESSION['username']){
   header("location:../");
   die;
}

include('connect.php');

$userNamee = $_SESSION['username'];
$userName = "%" .$userNamee . "%";

$cta = "SELECT id, cta, fullName, userClient FROM `pds_users` WHERE `username` = '$userNamee'";
$result = $connection->query($cta);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$id_userS = $row["id"];
		$ctaClient = $row["cta"];
		$ctaAcc = $ctaClient;
		$nombreDeUsuario = $row["fullName"];
		$nombreDeCliente = $row["userClient"];
	}
} else {
	echo "0 results1";
}

$skin = "SELECT logo, fondo, menu, tema, titulo FROM `pds_skin` WHERE `id_user` = '$id_userS'";
$result = $connection->query($skin);
if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
		$logoClient=$row["logo"];
		$fondoClient=$row["fondo"];
		$menuClient=$row["menu"];
		$temaClient=$row["tema"];
		$tituloClient=$row["titulo"];
        }
}








$cta = "SELECT username FROM `pds_users` WHERE `cta` = '$ctaClient'";
$result = $connection->query($cta);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$usersAccount = $row["username"];
	}
} else {
	echo "0 results2";
}


$sql = "SELECT cta FROM `pds_clients` WHERE users like '$userName'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$clientPathReal = $row["cta"];
		$clientPathimg = "../clientes/" . $row["cta"] . "/imagenes";
		$clientPathimgS = "../clientes/" . $row["cta"] . "/imagenes/";
		$clientPathBan = "../clientes/" . $row["cta"] . "/banners";
		$clientPathBanS = "../clientes/" . $row["cta"] . "/banners/";
		$clientPathlogo = "../clientes/" . $row["cta"] . "/logos";
		$clientPathlogoS = "../clientes/" . $row["cta"] . "/logos/";
		$clientPathVideo = "../clientes/" . $row["cta"] . "/videos";
		$clientPathVideoS = "../clientes/" . $row["cta"] . "/videos/";
		$clientPathVideosHtml = "../clientes/" . $row["cta"] . "/videoHTML/";
		$clientPathAudio = "../clientes/" . $row["cta"] . "/audios";
		$clientPathAudioS = "../clientes/" . $row["cta"] . "/audios/";
		$clientPathmusica = "../clientes/" . $row["cta"] . "/audios/";
		$clientPathColorRss     = "../clientes/" . $row["cta"] . "/templates/TemplateColors";
	        $clientPathColorRssS    = "../clientes/" . $row["cta"] . "/templates/TemplateColors/";
		
	}
} else {
}

/*
$sql = "SELECT plantillas_especiales FROM `pds_clients` WHERE cta='$clientPathReal'";
$result = $connection->query($sql);
while($row = $result->fetch_assoc()) {
	$platillasEspeciales=$row["plantillas_especiales"];
}
 */
if ($ctaClient == "cta1") {
$sql = "SELECT * FROM pds_players WHERE status = 'on'";
} else {
$sql_userZone = "SELECT id_zone FROM pds_userZone WHERE id_user = '$id_userS'";
$result_userZone = $connection->query($sql_userZone);
$cont = 1;      $has_zones = 0;
while($row_uZ = $result_userZone->fetch_assoc()) {
	$id_uZ = $row_uZ["id_zone"];
	$query_id .= "id='".$id_uZ."' OR ";     $query_idUZ = substr($query_id, 0, -3);
	$cont ++;
}
if( $cont > 1){
	$sql = "SELECT * FROM pds_zones WHERE cta like '$ctaAcc' AND ($query_idUZ)";

	$consultaE = "";
	$result = $connection->query($sql);
	while($row = $result->fetch_assoc()) {
		$cont = substr_count($row['players'],",");
		$condE = explode(",", $row['players']);
		for($i = 0; $i <= $cont; $i++){
			$consultaE .= "pds_players.mac = '".$condE[$i]."' OR "; $has_zones = 1;
		}
	}
	$query_macs = substr($consultaE,0,-3);
}
$sql = "SELECT * FROM pds_players INNER JOIN pds_informacion WHERE ($query_macs) AND pds_players.status = 'on' AND pds_players.mac = pds_informacion.mac ORDER BY pds_players.status DESC";
if($has_zones == 0)
	$sql = "SELECT * FROM pds_players INNER JOIN pds_informacion WHERE pds_players.cta='$ctaAcc' AND pds_players.status = 'on' AND pds_players.mac = pds_informacion.mac ORDER BY pds_players.status DESC";	
//echo $sql;
//$sql = "SELECT count(*) as total FROM `pds_players` WHERE `status` = 'on' AND `cta` = '$ctaClient'";
//
}
$result = $connection->query($sql);
$$PlayersOn = 0;
while($row = $result->fetch_assoc()) {

	//$PlayersOn = $row["total"];
	$PlayersOn ++;
}

if ($ctaClient == "cta1") {
$sql = "SELECT * FROM pds_players WHERE status = 'off'";
} else {
$sql_userZone = "SELECT id_zone FROM pds_userZone WHERE id_user = '$id_userS'";
$result_userZone = $connection->query($sql_userZone);
$cont = 1;      $has_zones = 0;
while($row_uZ = $result_userZone->fetch_assoc()) {
        $id_uZ = $row_uZ["id_zone"];
        $query_id .= "id='".$id_uZ."' OR ";     $query_idUZ = substr($query_id, 0, -3);
        $cont ++;
}
if( $cont > 1){
        $sql = "SELECT * FROM pds_zones WHERE cta like '$ctaAcc' AND ($query_idUZ)";

        $consultaE = "";
        $result = $connection->query($sql);
        while($row = $result->fetch_assoc()) {
                $cont = substr_count($row['players'],",");
                $condE = explode(",", $row['players']);
                for($i = 0; $i <= $cont; $i++){
                        $consultaE .= "pds_players.mac = '".$condE[$i]."' OR "; $has_zones = 1;
                }
        }
        $query_macs = substr($consultaE,0,-3);
}
$sql = "SELECT * FROM pds_players INNER JOIN pds_informacion WHERE ($query_macs) AND pds_players.status = 'off' AND pds_players.mac = pds_informacion.mac ORDER BY pds_players.status DESC";
if($has_zones == 0)
        $sql = "SELECT * FROM pds_players INNER JOIN pds_informacion WHERE pds_players.cta='$ctaAcc' AND pds_players.status = 'off' AND pds_players.mac = pds_informacion.mac ORDER BY pds_players.status DESC";
$PlayersOff = 0;
	
//$sql = "SELECT count(*) as total FROM `pds_players` WHERE `status` = 'off' AND `cta` = '$ctaClient'";
}
$result = $connection->query($sql);
while($row = $result->fetch_assoc()) {
	//$PlayersOff = $row["total"];
	$PlayersOff ++;
}
if ($ctaClient == "cta1") {
$sql = "SELECT * FROM pds_players";
} else {
	$sql_userZone = "SELECT id_zone FROM pds_userZone WHERE id_user = '$id_userS'";
$result_userZone = $connection->query($sql_userZone);
$cont = 1;      $has_zones = 0;
while($row_uZ = $result_userZone->fetch_assoc()) {
        $id_uZ = $row_uZ["id_zone"];
        $query_id .= "id='".$id_uZ."' OR ";     $query_idUZ = substr($query_id, 0, -3);
        $cont ++;
}
if( $cont > 1){
        $sql = "SELECT * FROM pds_zones WHERE cta like '$ctaAcc' AND ($query_idUZ)";

        $consultaE = "";
        $result = $connection->query($sql);
        while($row = $result->fetch_assoc()) {
                $cont = substr_count($row['players'],",");
                $condE = explode(",", $row['players']);
                for($i = 0; $i <= $cont; $i++){
                        $consultaE .= "pds_players.mac = '".$condE[$i]."' OR "; $has_zones = 1;
                }
        }
        $query_macs = substr($consultaE,0,-3);
}
$sql = "SELECT * FROM pds_players INNER JOIN pds_informacion WHERE ($query_macs) AND pds_players.mac = pds_informacion.mac ORDER BY pds_players.status DESC";
if($has_zones == 0)
        $sql = "SELECT * FROM pds_players INNER JOIN pds_informacion WHERE pds_players.cta='$ctaAcc' AND pds_players.mac = pds_informacion.mac ORDER BY pds_players.status DESC";

//$sql = "SELECT count(*) as total FROM `pds_players` WHERE `cta` = '$ctaClient'";
}
$result = $connection->query($sql);
$PlayersTotal = 0;
while($row = $result->fetch_assoc()) {
	//$PlayersTotal = $row["total"];
	$PlayersTotal ++;
}

/* PARA LA PARTE DE USUARIOS */
$id_user  = $_SESSION['id_user'];
$sql = "select userType from pds_users where username ='".$userNamee."' and id = ".$id_user."";
$result = $connection->query($sql);
$row = $result->fetch_assoc();
$id_grupo=$row['userType'];
$sql = "select permiso from pds_web_privilegios where id_grupo = ".$id_grupo;
$campos_permitidos = $connection->query($sql);


?>
