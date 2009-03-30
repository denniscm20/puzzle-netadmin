<?php
	
	define ("MODULO_IPTABLES","iptables");
	define ("SERVICIO_IPTABLES", "iptables");
	
	// Árbol de directorios
	define ("RAIZ_IPTABLES", MODULO.MODULO_IPTABLES);
	define ("BASE_DATOS_IPTABLES",RAIZ."/archivo/iptables.db");
	
	define ("VISTA_IPTABLES",RAIZ_IPTABLES."/vista/");
	define ("CLASES_IPTABLES",RAIZ_IPTABLES."/modelo/clases/");
	define ("DAO_IPTABLES",RAIZ_IPTABLES."/modelo/dao/");
	define ("CONTROLADOR_IPTABLES",RAIZ_IPTABLES."/controlador/");
			
	define ("CSS_IPTABLES", "./modulo/".MODULO_IPTABLES."/css/");
	define ("JS_IPTABLES", "./modulo/".MODULO_IPTABLES."/vista/js/");
	define ("IMAGENES_IPTABLES", "./modulo/".MODULO_IPTABLES."/vista/imagenes/");

	$lModuloList[] = MODULO_IPTABLES;
	$lServicioList[] = SERVICIO_IPTABLES;
?>