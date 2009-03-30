<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'Nodo.php';
require_once CLASES.'Subred.php';
require_once CONTROLADOR_IPTABLES.'ControladorIptables.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaIptables extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aIptables = null;
	
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
		
		$this->aIptables = $this->aControlador->getIptables();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=Iptables&Modulo=Iptables";
		if (isset($_GET["Origen"])) {
			$lRegla = $_GET["Origen"];
			if (($lRegla == "Importar") or ($lRegla == "404")) {
				$lAccion .= "&Origen=".$lRegla;
			} else {
				header("Location:".$lAccion."&Origen=404");
			}
		}
	?>
		<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Configuraci&oacute;n del Iptables</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=Iptables&amp;Modulo=Iptables">
						<img src="<?=IMAGENES_IPTABLES?>boton/policy.png" alt="[Configuración]" title="Configuración">&nbsp;Configurar Iptables
						</a>
						&nbsp;
						<a href="index.php?Pagina=Iptables&amp;Modulo=Iptables&amp;Origen=Importar">
						<img src="<?=IMAGENES_IPTABLES?>boton/import.png" alt="[Importar]" title="Importar Configuración">&nbsp;Importar Configuración
						</a>
					</div>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<?
								$lFuncion = "texto".(isset($_GET["Origen"])?$_GET["Origen"]:"");
								$this->{$lFuncion}();
							?>
						</td>
					</tr>
					</table>
					<?
					$lFuncion = "cargar".(isset($_GET["Origen"])?$_GET["Origen"]:"");
					$this->{$lFuncion}($lAccion);
					?>
				</td>
			</tr>
			</table>
			<br>
	<?	
	} // end of member function contenido

	protected function texto(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla registre una breve descripción para la
		configuración que vaya a crear.
		</p>
		<?
	}
	
	protected function textoImportar(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla cargue los valores haciendo uso de un archivo de
		configuración previamente exportado por la aplicación.
		</p>
		<?
	}
	
	protected function cargar($pAccion) {
		?>
		<form id="ActionForm" name="ActionForm" action="<?=$pAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<fieldset>
				<legend>Valores Generales</legend>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr><td valign="top">Descripción: </td>
					<td><?=Html::TextArea("txtDescripcion", "", 3, 65, "on", 1, "textfield")?>
					</td>
					</tr>
					<tr><td colspan="2" align="right"><?=Html::Button("btnGuardar", "Guardar", 2, "button", "evtGuardar()")?></td></tr>
				</table>
			</fieldset>
		</form>
		<?
	}
	
	protected function cargarImportar($pAccion) {
		?>
		<form id="ActionForm" name="ActionForm" enctype="multipart/form-data" action="<?=$pAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<fieldset>
				<legend>Importar Configuración</legend>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr><td>Archivo a Importar:</td>
					<td>
					<INPUT type="hidden" name="MAX_FILE_SIZE" value="10000" />
					<INPUT type="file" name="txtFile" id="txtFile" class="textfield">
					</td>
					</tr>
					<tr><td colspan="2" align="right"><?=Html::Button("btnImportar", "Importar", 2, "button", "evtImportar()")?></td></tr>
				</table>
			</fieldset>
		</form>
		<?
	}
	
	protected function texto404($pAccion){
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
