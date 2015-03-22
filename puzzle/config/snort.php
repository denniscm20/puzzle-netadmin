<?php
	
	define ("MODULO_SNORT","snort");
	define ("SERVICIO_SNORT", "snortd");
	
	// Árbol de directorios
	define ("RAIZ_SNORT", MODULO.MODULO_SNORT);
	define ("BASE_DATOS_SNORT",RAIZ."/archivo/snort.db");
	
	define ("VISTA_SNORT",RAIZ_SNORT."/vista/");
	define ("CLASES_SNORT",RAIZ_SNORT."/modelo/clases/");
	define ("DAO_SNORT",RAIZ_SNORT."/modelo/dao/");
	define ("CONTROLADOR_SNORT",RAIZ_SNORT."/controlador/");
			
	define ("CSS_SNORT", "./modulo/".MODULO_SNORT."/vista/css/");
	define ("JS_SNORT", "./modulo/".MODULO_SNORT."/vista/js/");
	define ("IMAGENES_SNORT", "./modulo/".MODULO_SNORT."/vista/imagenes/");
	
	$lModuloList[] = MODULO_SNORT;
	$lServicioList[] = SERVICIO_SNORT;

?>