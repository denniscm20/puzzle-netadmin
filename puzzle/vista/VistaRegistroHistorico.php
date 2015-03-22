<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR.'ControladorRegistroHistorico.php';
require_once CLASES.'RegistroHistorico.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaRegistroHistorico extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aRegistrosHistoricos = array();
	
	/**
	* Constructor de la VistaInterfaz.
	*
	* @param controlador::ControladorInterfaz pControlador Controlador de la pantalla.
	* @return 
	* @access private
	*/
	public function __construct( $pControlador = null ) {
		$this->aControlador = $pControlador;
		$this->aRestringido = true;
		$lEvento = "";
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
		}
		$this->aControlador->procesar($lEvento);
		
		$this->aRegistrosHistoricos = $this->aControlador->getRegistrosHistoricos();
	} // end of member function __construct

	public function contenido( ) {
		$lAccion = "index.php?Pagina=RegistroHistorico";
		if (isset($_GET["Criterio"])) {
			$lCriterio = $_GET["Criterio"];
			if (($lCriterio == "") or ($lCriterio == "Fecha") or ($lCriterio == "Usuario") or ($lCriterio == "404")) {
				$lAccion .= "&Criterio=".$_GET["Criterio"];
			} else {
				header("Location:index.php?Pagina=RegistroHistorico&Criterio=404");
			}
		}
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>

			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Registro Histórico de Accesos al Sistema</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=RegistroHistorico">
						<img src="<?=IMAGENES?>boton/hostname.png" alt="[últimos]" title="Últimos Registros">&nbsp;Últimos Registros
						</a>
						&nbsp;
						<a href="index.php?Pagina=RegistroHistorico&Criterio=Fecha">
						<img src="<?=IMAGENES?>boton/nodo.png" alt="[Fecha]" title="Buscar por Fecha">&nbsp;Buscar por Fecha
						</a>
						&nbsp;
						<a href="index.php?Pagina=RegistroHistorico&Criterio=Usuario">
						<img src="<?=IMAGENES?>boton/user.png" alt="[Usuario]" title="Buscar por Usuario">&nbsp;Buscar por Usuario
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<br>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<?
								$lFuncion = "texto".(isset($_GET["Criterio"])?$_GET["Criterio"]:"");
								$this->{$lFuncion}();
							?>
						</td>
					</tr>
					</table>
					<? 
					$lFuncion = "cargar".(isset($_GET["Criterio"])?$_GET["Criterio"]:"");
					$this->{$lFuncion}();
					?>
					<fieldset>
						<legend>Listado de Registros</legend>
						<?
						$lHeader = array("N&deg;", "Fecha / Hora", "Usuario", "IP", "Mensaje");
						$lTabla = new Tabla($lHeader);
						$lNum = 0;
						foreach($this->aRegistrosHistoricos as $lRegistroHistorico) {
							$lNum++;
							$lFecha = date("d-m-Y", strtotime($lRegistroHistorico->Fecha))."&nbsp;".$lRegistroHistorico->Hora;
							$lFila = array($lNum, $lFecha, $lRegistroHistorico->Usuario, $lRegistroHistorico->IP, $lRegistroHistorico->Mensaje);
							$lTabla->addRow($lFila);
						}
						echo $lTabla;
						?>
					</fieldset>
				</td>
			</tr>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido

	protected function texto(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede realizar consultas para obtener los últimos registros históricos.
		</p>
		<?
	}
	
	protected function cargar(){
		?>
		<fieldset>
			<legend>Criterio de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td valign="top" width="120px"><label accesskey="n" for="txtUltimos">Obtener <u>Ú</u>ltimos:</label></td>
				<td align="left" valign="top" width="200px"><?=HTML::TextBox("txtUltimos","",2,2,1,"textField");?>&nbsp;registros</td>
				<td align="right"><?=HTML::button("btnBuscar","Buscar",2,"button","evtBuscar()")?></td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function textoFecha(){
		?>
		<p align="center">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede realizar consultas sobre los intentos de acceso ocurridos dentro de un rango de fecha.
		</p>
		<?
	}
	
	protected function cargarFecha(){
		?>
		<fieldset>
			<legend>Criterio de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>Fecha Inicial: </td>
				<td><?=HTML::TextBox("txtFechaInicio", "", 10, 10, 1, "textField")?></td>
				<td>Fecha Final: </td>
				<td><?=HTML::TextBox("txtFechaFin", "", 10, 10, 2, "textField")?></td>
				<td><?=HTML::Button("btnBuscar","Buscar",3,"button","evtBuscar()");?></td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function textoUsuario(){
		?>
		<p align="center" style="font-weight:normal;">
				<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede realizar consultas sobre los intentos de acceso efectuados por un usuario.
		</p>
		<?
	}
	
	protected function cargarUsuario(){
		?>
		<fieldset>
			<legend>Criterio de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td valign="top" width="120px"><label accesskey="n" for="txtUltimos">Nombre de <u>Ú</u>suario:</label></td>
				<td align="left" valign="top" width="200px"><?=HTML::TextBox("txtUsuario","",20,20,1,"textField");?></td>
				<td align="right"><?=HTML::button("btnBuscar","Buscar",2,"button","evtBuscar()")?></td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function texto404(){
		?>
		<p align="center" style="font-weight:bold;">
		<img alt="[Error]" src="<?=IMAGENES?>mensaje/error.png">No ha sido posible encontrar la Página Solicitada.
		</p>
		<p align="center">
		(**) Se recomienda no modificar los valores ubicados en la barra URL del navegador.
		</p>
		<?
	}
	
	protected function cargar404() {
	}
} // end of VistaAdministrarInterfaz
?>
