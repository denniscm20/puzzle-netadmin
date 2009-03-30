<?php

	require (LIB."html.php");
	$lSessionDestroy = false;
	//session_start();
	if (session_is_registered("usuario")) {
		session_unset();
		$lSessionDestroy = session_destroy();
	}
	
	$lClass = "info";
	$lAlt = "Info";
	$lImagen = "mensaje/info.png";
	$lMensaje = "exitosamente";
	if (!$lSessionDestroy) {
		$lClass = "error";
		$lAlt = "Error";
		$lImagen = "mensaje/error.png";
		$lMensaje = "con errores";
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Iniciar Sesi&oacute;n</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="StyleSheet" type="text/css" href="<?= CSS ?>login.css" >
</head>

<body>
	<div align="center" style="margin-top:100px; height: 200px; ">
		<p class="<?=$lClass?>"><img alt="[<?=$lAlt?>]" src="<?=IMAGENES.$lImagen?>"> Su sesi&oacute;n ha sido cerrada <?=$lMensaje?></p>
		<form action="index.php" method="POST">
		<p><?= HTML::submitButton("Nueva Sesion","Iniciar Sesión",0,"button") ?></p >
		</form>
	</div>
</body>
</html>