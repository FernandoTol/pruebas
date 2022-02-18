<?php
session_start();
if(!$_SESSION['username']){
   header("location:../");
   die;
}

include('../includes/connect.php');
include('../includes/path.php');
$header = "
    <header id='header' class='page-topbar'>
        <!-- start header nav-->
        
        <div class='navbar-fixed'>
            <nav class='navbar-color'>
                <div class='nav-wrapper'>
		    <ul class='left'>                      
                      <li>\n<h1 class='logo-wrapper'>\n<a href='index.php' class='brand-logo darken-1'>\n<img src='../images/logo-dash.png' alt='PDS Logo'>\n</a> <span class='logo-text'>DIGITAL CONTENTS PLATFORM</span>\n</h1>\n</li>
                    </ul>
                    <ul class='right hide-on-med-and-down'>
                        <li>\n<a href='javascript:void(0);' class='waves-effect waves-block waves-light notification-button' data-activates='notifications-dropdown'>\n<i class='mdi-action-account-circle'>\n</i>\n</a>
                        </li>                        

                    </ul>
                    <!-- translation-button -->
                    <!-- notifications-dropdown -->

                    <ul id='notifications-dropdown' class='dropdown-content'>
                      <li>
                        <a style='color: #000;' href='logout.php'>\n<h5>Cambiar Contraseña</h5>\n</a>
                      </li>
                      <li>
                        <a style='color: #000;' href='husoHorario.php'>\n<h5>Modificar Huso horario</h5>\n</a>
                      </li>

                      <li>
                        <a style='color: #000;' target='_blank' href='/portal/dashboard/DIGITAL_SIGNAGE_PLATFORM.pdf'>\n<h5>Ayuda</h5>\n</a>
                      </li>
                      <li>
                        <a style='color: #000;' href='logout.php'>\n<h5>Cerrar Sesión</h5>\n</a>
                      </li>

                    </ul>
                </div>
            </nav>
        </div>
                    <aside id='left-sidebar-nav' class='nav-expanded nav-lock nav-collapsible'>
              <a href='#' data-activates='slide-out' class='sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only gradient-45deg-light-blue-cyan gradient-shadow'>
                <i class='material-icons'>menu</i>
              </a>
            </aside>
        <!-- end header nav-->
    </header>
";

$mainMenu = "
	<aside id='left-sidebar-nav'>
		<ul id='slide-out' class='side-nav fixed leftside-navigation'>
			<li class='user-details cyan darken-2' style='margin-bottom: 0px;'>
				<div class='row'>
					<div class='col col s8 m8 l8'>
						<a class='btn-flat dropdown-button waves-effect waves-light white-text profile-btn' href='#' >$nombreDeUsuario</a>
						<p class='user-roal'>$nombreDeCliente</p>
					</div>
				</div>
			</li>";
			$posi = 0;
			$cont = 0;
			$tamlista=mysqli_num_rows($campos_permitidos);
			while($value = $campos_permitidos->fetch_assoc()){
				$cont = $cont+1;
				$arreglo = explode(";", $value['permiso']);
				$tam=sizeof($arreglo);
				$sql_permi="";
				if ($tam == 1){
					$sql_permi="select * from pds_web_secciones where id_grupo1=".$arreglo[0];
				}
				elseif($tam == 2){
					$sql_permi="select * from pds_web_modulos where id_grupo1=".$arreglo[0]." and id_grupo2=".$arreglo[1];
				}
				elseif($tam == 3){
					$sql_permi="select * from pds_web_submodulos where id_grupo3=".$arreglo[2]." and id_grupo2=".$arreglo[1];
				}
				elseif($tam == 4){
					$sql_permi="select * from pds_web_complementos where id_grupo4=".$arreglo[3]." and id_grupo3=".$arreglo[2];
				}
				$resultado = $connection->query($sql_permi);
				$datosElemento = $resultado->fetch_assoc();
				if ($posi>$tam){
					if ($posi==4 && $tam==1){
						$mainMenu .= "</ul>\n</div>\n</li>\n</ul>\n</div>\n</li>\n</ul>\n</li>";
					}
					if ($posi==4 && $tam==2){
						$mainMenu .= "</ul>\n</div>\n</li>\n</ul>\n</div>\n</li>";
						$posi=1;
					}
					if ($posi==4 && $tam==3){
						$mainMenu .= "</ul>\n</div>\n</li>";
						$posi=2;
					}
					if ($posi==3 && $tam==1){
						$mainMenu .= "</ul>\n</div>\n</li>\n</ul>\n</li>";
					}
					if ($posi==3 && $tam==2){
						$mainMenu .= "</ul>\n</div>\n</li>";
						$posi=1;
					}
					if ($posi==2 && $tam==1){
						$mainMenu .= "</ul>\n</li>";
					}
				}
				if ($tam == 1){
					$mainMenu.="
					<li class='li-hover'>\n<div class='divider'>\n</div>\n</li>
		                        <li class='li-hover'>\n<p class='ultra-small margin more-text'>".$datosElemento['nom_elemento'.$tam]."</p>\n</li>
		                        <li class='no-padding'>
                		        <ul class='collapsible collapsible-accordion'>\n";
					$posi=1;
				}
				elseif ($tam == 2){
					if ($datosElemento['url']=="Default"){
						$mainMenu.="<li class='bold '>\n<a class='collapsible-header waves-effect waves-cyan' id='".$datosElemento['id_html']."'>\n<i class='".$datosElemento['class']."'>\n</i> ".$datosElemento['nom_elemento'.$tam]."</a>\n<div class='collapsible-body'>\n<ul class='collapsible collapsible-accordion'>\n";
					}
					else{
                				$mainMenu.="<li class='bold ' id='".$datosElemento['id_html']."'>\n<a href='".$datosElemento['url']."' class='waves-effect waves-cyan'>\n<i class='".$datosElemento['class']."'>\n</i> ".$datosElemento['nom_elemento'.$tam]."</a>\n</li>\n";
					}
					$posi=2;
				}
				elseif ($tam == 3){
					if ($datosElemento['url']=="Default"){
						$mainMenu .= "<li>\n<a class='collapsible-header waves-effect waves-cyan' id='".$datosElemento['id_html']."'> ".$datosElemento['nom_elemento'.$tam]." </a>\n<div class='collapsible-body'>\n<ul>\n";
					}
					else{
						$mainMenu.="<li class='' id='".$datosElemento['id_html']."'>\n<a href='".$datosElemento['url']."'>".$datosElemento['nom_elemento'.$tam]."</a>\n</li>\n";

					}
					$posi=3;
				}
				elseif ($tam == 4){
					$mainMenu.="<li id='".$datosElemento['id_html']."'>\n<a href='".$datosElemento['url']."' class='waves-effect waves-cyan'>\n<i>\n</i>&#x2001;&#x2001;".$datosElemento['nom_elemento'.$tam]."</a>\n</li>\n";
					$posi=4;
				}
				if ($cont==$tamlista){
					if ($tam==4){
						$mainMenu .= "</ul>\n</div>\n</li>\n</ul>\n</div>\n</li>\n</ul>\n</li>";
					}
					if ($tam==3){
						$mainMenu .= "</ul>\n</div>\n</li>\n</ul>\n</li>";
					}
					if ($tam==2 || $tam==1){
						$mainMenu .= "</ul>\n</li>";
					}
				}
			} 
			$mainMenu.="<li class='li-hover'>\n<div class='divider'>\n</div>\n</li>\n<div style='padding-bottom:30px;'>\n</div>\n<div style='padding-bottom:30px;'>\n</div>\n</ul>\n</aside>";
			/*
			$myfile = fopen("opciones.php", "w") or die("Unable to open file!");
			$txt = $mainMenu."\n";
			fwrite($myfile, $txt);
			fclose($myfile);
			 */

?>
