<?php
	
	require_once(PLANTILLA."cabecera.php");
	require_once(PLANTILLA."pie.php");
	require_once(PLANTILLA."menu.php");
	
	function cargarVista($pPagina, $pModulo) {
		$lVista = "";
		if ($pModulo == "") {
			$lVista = VISTA."Vista".$pPagina.".php";
		} else {
			$lVista = MODULO.$pModulo."/vista/Vista".$pPagina.".php";
		}
		
		require_once($lVista);
	}
	
	function cargarControlador($pPagina, $pModulo) {
		$lControlador = "";
		if ($pModulo == "") {
			$lControlador = CONTROLADOR."Controlador".$pPagina.".php";
		} else {
			$lControlador = MODULO.$pModulo."/controlador/Controlador".$pPagina.".php";
		}
		
		require_once ($lControlador);
	}
	
	function Main($pPagina, $lModulo = "") {
		$lVistaPagina = "Vista".$pPagina;
		$lControladorPagina = "Controlador".$pPagina;
		
		cargarControlador($pPagina,$lModulo);
		cargarVista($pPagina,$lModulo);
		
		eval('$lControlador = '.$lControladorPagina.'::obtenerInstancia();');
		$lVista = new $lVistaPagina($lControlador);
		
		$lPath = "JS".(trim($lModulo) != ""?"_".strtoupper(trim($lModulo)):"");
		eval ('$lEvento = '. $lPath.';');
		$lEvento .= "evento".$pPagina.".js";
?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
	<title>Proyecto de Fin de Carrera: Puzzle</title>
	<meta name="GENERATOR" content="Quanta Plus">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="<?=CSS?>menu.css" >
	<link rel="stylesheet" type="text/css" href="<?=CSS?>estilo.css" >
	<link rel="stylesheet" type="text/css" href="<?=CSS?>icon_menu.css" >
	<link rel="stylesheet" type="text/css" href="<?=CSS?>domtab.css" >
	<link rel="stylesheet" type="text/css" href="<?=CSS?>tabla.css" >
	<script language="javascript" type="text/javascript" src="<?=$lEvento?>" ></script>
	<script type="text/javascript" src="/vista/js/domtab.js"></script>
	<script type="text/javascript" src="/vista/js/menu.js"></script>
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#e6ffcc">
	<tr>
		<td colspan="2" style="background-image:
		url('/pagina/imagenes/header_back.jpg'); width:100%; height:150px; padding-left:5px; padding-right:5px;">
			<?php Cabecera();?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php if (isset($_SESSION["advertencia"])) { 
				if ($_SESSION["advertencia"] != "") { ?>
					<div class="advertencia">
					<img alt="[Advertencia]" src="<?=IMAGENES?>mensaje/warning.png"> &nbsp;<?=$_SESSION["advertencia"];?> </div>
					<?php $_SESSION["advertencia"] = "";
				}
			} else if (isset($_SESSION["info"])) {
				if ($_SESSION["info"] != "") { ?>
					<div class="info">
					<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> &nbsp;<?=$_SESSION["info"];?> </div>
					<?php	$_SESSION["info"] = "";
				}
			} else if (isset($_SESSION["error"])) { 
				if ($_SESSION["error"] != "") {?>
					<div class="error">
					<img alt="[Error]" src="<?=IMAGENES?>mensaje/error.png"> &nbsp;<?=$_SESSION["error"];?> </div>
					<?php	$_SESSION["error"] = "";
				}
			}?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="width:150px; padding-top:10px;">
			<?php
			$lUsuario = unserialize($_SESSION["usuario"]);
			Menu($lUsuario->Administrador);
			?>
		</td>
		<td width="650" valign="top">
			<!-- Contenido -->
			<?php 
				if ($lVista->restringido()) {
					if ($lUsuario->Administrador) {
						$lVista->contenido();
					} else {
						include PLANTILLA.'error403.php';
					}
				} else {
					$lVista->contenido(); 
				}
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="background-image:url('/pagina/imagenes/footer_back.jpg'); width:100%; height:40px; ">
			<?php Pie();?>
		</td>
	</tr>
	</table>
</body>
</html>
<?php
	}
?>