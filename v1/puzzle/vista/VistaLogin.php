<?php
	
	require_once(CONTROLADOR."ControladorLogin.php");
	
	$lControlador = ControladorLogin::obtenerInstancia();
	
	$lLogueoExitoso = true;
	if (isset($_POST["Evento"])) {
		
		require_once(CLASES."Usuario.php");
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
			if ($lEvento != "") {
				$lControlador->{$lEvento}();
			}
		}
		
		$lUsuario = $lControlador->getUsuario();
		$lLogueoExitoso = ($lUsuario) != null;
		if ($lLogueoExitoso) {
			session_start();
			$_SESSION["usuario"] = serialize($lUsuario);
			session_write_close();
			header("Location: index.php?Pagina=PanelControl");
		}
	}
	
	require_once(LIB."html.php");	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Iniciar Sesi&oacute;n</title>
    <meta name="GENERATOR" content="Quanta Plus">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="StyleSheet" type="text/css" href="<?= CSS ?>login.css" >
	<script language="javascript" type="text/javascript" src="./vista/js/encriptar.js" ></script>
	<script language="javascript" type="text/javascript" src="./vista/js/event.js" ></script>
  </head>
  <body>
		<?if (!$lControlador->esIPValida($_SERVER['REMOTE_ADDR'])) { 
			$lControlador->accesoNoAutorizado();
		?>
		<div class="error" style="padding-top: 100px;">
			<img alt="[Error]" src="<?=IMAGENES?>mensaje/error.png"> &nbsp;Usted no está autorizado para acceder a esta p&aacute;gina 
		</div>
		<?	} else {?>
		<table id="content" align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="150" height="150" valign="middle">
		<img alt="[Imagen de Inicio de Sesión]" src="<?=IMAGENES?>login_left.jpg" width="150" height="150"></td>
		<td width="350" height="150" valign="middle" align="center" bgcolor="#006600" >
          <form id="ActionForm" name="ActionForm" action="index.php?Pagina=Login" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<div align="center" class="line"><label accesskey="u" for="txtUsuario" ><u>U</u>suario</label><span><?= HTML::TextBox("txtUsuario","",20,20,1,"textField");?></span></div>
			<div align="center" class="line"><label accesskey="c" for="txtPassword" ><u>C</u>ontrase&ntilde;a:</label><span><?= HTML::Password("txtPassword","",20,255,2,"textField");?></span></div>
			<div align="right" class="line"><?=HTML::Button("btnAceptar","Ingresar",3,"button","evtLogin()")."&nbsp;".HTML::ResetButton("btnLimpiar","Limpiar",4,"button");?></div>
          </form>
        </td>
      </tr>
      <tr>
		<td height="50" colspan="2" bgcolor="#e6ffcc">
          <div id="text" > - Todos los derechos reservados - <br> &reg; 2008 </div>
        </td>
      </tr>
    </table>
    <br>
    <? if (!$lLogueoExitoso) {
    ?>
    <div class="error">
      <img alt="[Error]" src="<?=IMAGENES?>mensaje/error.png"> &nbsp;Usuario y/o Contrase&ntilde;a incorrectos </div>
    <? } 
	}?>
  </body>
</html>
