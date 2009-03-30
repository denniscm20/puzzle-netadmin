<?php
	
	define ("MODULO_SQUID","squid");
	define ("SERVICIO_SQUID","squid");
	
	// Árbol de directorios
	define ("RAIZ_SQUID", MODULO.MODULO_SQUID);
	define ("BASE_DATOS_SQUID",RAIZ."/archivo/squid.db");
	
	define ("VISTA_SQUID",RAIZ_SQUID."/vista/");
	define ("CLASES_SQUID",RAIZ_SQUID."/modelo/clases/");
	define ("DAO_SQUID",RAIZ_SQUID."/modelo/dao/");
	define ("CONTROLADOR_SQUID",RAIZ_SQUID."/controlador/");
			
	define ("CSS_SQUID", "./modulo/".MODULO_SQUID."/vista/css/");
	define ("JS_SQUID", "./modulo/".MODULO_SQUID."/vista/js/");
	define ("IMAGENES_SQUID", "./modulo/".MODULO_SQUID."/vista/imagenes/");
	
	$lModuloList[] = MODULO_SQUID;
	$lServicioList[] = SERVICIO_SQUID;

?>