<?php
	
	define ("PROYECTO", "Nombre del Proyecto");
	
	define ("RAIZ",$_SERVER['DOCUMENT_ROOT']);
	
	define ("BASE_DATOS",RAIZ."/archivo/puzzle.db");
	
	// Árbol de directorios
	define ("PLANTILLA", RAIZ."/pagina/");
	define ("CONFIG", RAIZ."/config/");
	define ("VISTA",RAIZ."/vista/");
	define ("CLASES",RAIZ."/modelo/clases/");
	define ("DAO",RAIZ."/modelo/dao/");
	define ("CONTROLADOR",RAIZ."/controlador/");
	define ("LIB",RAIZ."/lib/");
	define ("MODULO",RAIZ."/modulo/");
	define ("BASE",RAIZ."/base/");
	define ("TMP",RAIZ."/tmp/");

	define ("CSS", "/pagina/css/");
	define ("JS", "/vista/js/");
	define ("IMAGENES", "/vista/imagenes/");
	
	// Página a mostrar al no estar logueado
	define ("PAGINA_PREDEFINIDA","Login");
	define ("PAGINA_DESLOGUEO","Logout");

	define ("TIMEZONE", "America/Lima");
	
	$lModuloList = array();
	$lServicioList = array();
	
	$lNotModulos = array(".","..","config");
	$lModulos = scandir(MODULO);
	
	foreach ($lModulos as $lModulo) {
		if (!in_array($lModulo, $lNotModulos)) {
			require_once(CONFIG.$lModulo.".php");
		}
	}

	
?>