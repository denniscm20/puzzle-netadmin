<?php
	ob_start();
	require_once ("./config/config.php");

	/* Esta variable almacenará el valor de la página solicitada por el
	 * usuario.  En caso la página no exista, se procederá a mostrar la
	 * página establecida como PREDETERMINADA. */	
	$lPagina = PAGINA_PREDEFINIDA;
	$lModulo = "";
	
	session_start();
	
	date_default_timezone_set(TIMEZONE);

	/* Verificar que halla una sesión iniciada. */
	if (session_is_registered("usuario")) {
		
		require_once (LIB."helper.php");
	
		/* Verificar que la página solicitada exista. */
		if (isset($_GET["Pagina"])) {
			$lPagina = $_GET["Pagina"];
			$lModulo = isset($_GET["Modulo"])?strtolower($_GET["Modulo"]):"";
			$lPagina = Helper::validarPagina($lPagina, $lModulo);
					//(file_exists(VISTA."Vista".$lPagina.".php"))?$lPagina:PAGINA_PREDEFINIDA;
		}
		
	}
	
	/* Cargar la página a mostrar. */
	if ($lPagina != PAGINA_PREDEFINIDA and $lPagina != PAGINA_DESLOGUEO) {
		require_once(PLANTILLA."pagina.php");
		Main($lPagina, $lModulo);
	} else {
		require_once(VISTA."Vista".$lPagina.".php");
	}
	ob_end_flush();
?>