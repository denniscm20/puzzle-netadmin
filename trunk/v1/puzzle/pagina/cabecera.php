<?php
	function Cabecera() {
		require_once CLASES."Usuario.php";
		$lUsuario = unserialize($_SESSION["usuario"]);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="150"><img src="/pagina/imagenes/cabecera/logo.png" alt="[LOGO de la aplicación]" height="150"></td>
  <td align="center">
		<img src="/pagina/imagenes/cabecera/title.png" alt="[Título de la aplicación]">
  </td><td align="right" valign="bottom">
		<div>Bienvenido <span><?=$lUsuario->Nombre?></span></div><a href="/index.php?Pagina=Logout" style="color:#003300;"><img alt="[Salir]" src="/pagina/imagenes/cabecera/exit.png" style="padding-bottom:10px;"></a>
  </td></tr>
</table>
<?php
	}
?>