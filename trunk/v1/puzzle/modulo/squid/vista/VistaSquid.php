<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES.'Interfaz.php';
require_once CONTROLADOR_SQUID.'ControladorSquid.php';
require_once CLASES_SQUID.'Squid.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaSquid extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aSquid = null;
	private $aPagina = null;
	private $aTotalPuertos = null;
	private $aInterfaces = array();
	
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
		
		$this->aSquid = $this->aControlador->getSquid();
		$this->aPagina = $this->aControlador->getPagina();
		$this->aTotalPuertos = count($this->aSquid->HttpPort);
		$this->aInterfaces = $this->aControlador->getInterfaces();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=Squid&Modulo=Squid";
		$lRegla = "";
		if (isset($_GET["Origen"])) {
			$lRegla = $_GET["Origen"];
			if (($lRegla == "Importar") or ($lRegla == "404")) {
				$lAccion .= "&Origen=".$lRegla;
			} else {
				header("Location:".$lAccion."&Origen=404");
			}
		}
	?>
			<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>"<?=($lRegla=="Importar")?" enctype=\"multipart/form-data\"":""?> method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("Puerto","")?>
			<?=HTML::Hidden("Pagina",$this->aPagina)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Configuraci&oacute;n del Squid</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=Squid&amp;Modulo=Squid">
						<img src="<?=IMAGENES_SQUID?>boton/settings.png" alt="[Configuración]" title="Configuración">&nbsp;Configurar Squid
						</a>
						&nbsp;
						<a href="index.php?Pagina=Squid&amp;Modulo=Squid&amp;Origen=Importar">
						<img src="<?=IMAGENES_SQUID?>boton/import.png" alt="[Importar]" title="Importar Configuración">&nbsp;Importar Configuración
						</a>
					</div>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<? 
						$lFuncion = "";
						if($lRegla == "") {
							$lFuncion = "cargarPagina".$this->aPagina;
						} else {
							$lFuncion = "cargar".$lRegla;
						}
						$this->{$lFuncion}();
					?>
				</td>
			</tr>
			<? if($lRegla == "") { ?>
			<tr>
				<td align="right">
					<? 
						$lCaption = ($this->aPagina < 5)?"Siguiente":"Guardar";
						$lEvento = "evt".$lCaption."()";
					?>
					<?= ($this->aPagina > 0)? Html::Button("btnAnterior", "Anterior", 1, "button", "evtAnterior()") : "" ?>
					<?=Html::Button("btnSiguiente", $lCaption, 1, "button", $lEvento)?>
					<?=Html::Button("btnCancelar", "Cancelar", 1, "button", "evtCancelar()")?>
				</td>
			</tr>
			<? } ?>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido


	protected function cargarImportar() {
		?>
		<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
		<tr>
			<td>
				<p align="center" style="font-weight:normal;">
				<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla cargue los valores haciendo uso de un archivo de
				configuración previamente exportado por la aplicación.
				</p>
			</td>
		</tr>
		</table>
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
		<?
	}
		
	protected function cargar404() {
		?>
		<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
		<tr>
			<td>
				<p align="center" style="font-weight:bold;">
				<img alt="[Error]" src="<?=IMAGENES?>mensaje/error.png">No ha sido posible encontrar la Página Solicitada.
				</p>
				<p align="center">
				(**) Se recomienda no modificar los valores ubicados en la barra URL del navegador.
				</p>
			</td>
		</tr>
		</table>
		<?
	}
	
	protected function cargarPagina0(){
		?>
		<fieldset>
			<legend>Inicio de la Configuración</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>
					<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> La presente pantalla le guiará paso a paso a lo largo de toda la configuración de la herramienta Squid, 
	 				la cual le proporcionará las funcionalidades de un Proxy Firewall y de una Web Caché.</p>
					<p align="justify">Para dar inicio sírvase pulsar sobre el botón Siguiente ubicado en la parte inferior de la pantalla.</p>
				</td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function cargarPagina1(){
		?>
		<fieldset>
			<legend>Configuración de los Puertos</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>
					<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla seleccione el puerto en el cual se ejecutará el servicio de Proxy 
					(opcionalmente puede seleccionar la interfaz en la que se ejecutará el servicio).</p>
				</td>
			</tr>
			</table>
			<br>
			<?
				$lHeader = array("N&deg;","Interfaz","Puerto","Descripcion","Accion");
				$lTabla = new Tabla($lHeader);
				for ($i = 0; $i < $this->aTotalPuertos; $i++) {
					$lInterfaz = $this->aSquid->HttpPort[$i]->Interfaz->Nombre;
					$lPuerto = $this->aSquid->HttpPort[$i]->Puerto;
					$lDescripcion = $this->aSquid->HttpPort[$i]->Descripcion;
					$lAccion = HTML::ImageButton("btnEliminar", IMAGENES."boton/delete.png", "Eliminar Puerto", 0, "", "evtEliminarPuerto(".$i.")");
					$lFila = array($i + 1,$lInterfaz,$lPuerto,$lDescripcion,$lAccion);
					$lTabla->addRow($lFila);
				}
				
				$lInterfaz = HTML::ComboBox("cmbInterfaz", $this->aInterfaces, "ID", "Nombre", 0, 0, "combobox");
				$lPuerto = HTML::TextBox("txtPuerto", "", 6, 6, 0, "textField");
				$lDescripcion = HTML::TextBox("txtDescripcion", "", 30, 100, 0, "textField");
				$lAccion = HTML::ImageButton("btnNuevo", IMAGENES."boton/new.png", "Nuevo Puerto", 0, "", "evtAgregarPuerto()");
				$lFila = array("&nbsp;",$lInterfaz,$lPuerto,$lDescripcion,$lAccion);
				$lTabla->addRow($lFila);
				
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function cargarPagina2(){
		?>
		<fieldset>
			<legend>Configuración de la Caché</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>
				<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla se procederá a configurar las opciones de la caché.</p>
				</td>
			</tr>
			</table>
			<br>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td><label accesskey="d" for="txtCacheDir"><u>D</u>irectorio de la Caché:</label></td>
				<td><?=HTML::TextBox("txtCacheDir", $this->aSquid->CacheDir, 35, 100, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label accesskey="t" for="txtCacheDir"><u>T</u>amaño de la caché en disco (MB):</label></td>
				<td><?=HTML::TextBox("txtCacheMaxSize", $this->aSquid->CacheMaxSize, 6, 6, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label accesskey="s" for="txtDirNumber1">Número de <u>S</u>ubdirectorios:</label></td>
				<td><?=HTML::TextBox("txtDirNumber1", $this->aSquid->DirNumber1, 6, 6, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label accesskey="u" for="txtDirNumber2">Número de S<u>u</u>bdirectorios (Nivel 2):</label></td>
				<td><?=HTML::TextBox("txtDirNumber2", $this->aSquid->DirNumber2, 6, 6, 0, "textField");?></td>
			</tr>
			<tr>
				<td colspan="2">
				&nbsp;
				</td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function cargarPagina3(){
		?>
		<fieldset>
			<legend>Configuración del Log</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>
				<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla se procederá a configurar los nombres y rutas de los archivos de log.</p>
				</td>
			</tr>
			</table>
			<br>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td><label accesskey="c" for="txtCacheLog">Log de la <u>C</u>aché:</label></td>
				<td><?=HTML::TextBox("txtCacheLog", $this->aSquid->CacheLog, 35, 100, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label accesskey="a" for="txtAccessLog">Log de <u>A</u>cceso:</label></td>
				<td><?=HTML::TextBox("txtAccessLog", $this->aSquid->AccessLog, 35, 100, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label accesskey="l" for="txtStoreLog">Log de A<u>l</u>macenaje:</label></td>
				<td><?=HTML::TextBox("txtStoreLog", $this->aSquid->StoreLog, 35, 100, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label accesskey="h" for="chkLogFqdn"><u>H</u>abilitar almacenaje por dominio:</label></td>
					<td><?=HTML::CheckBox("chkLogFqdn", 1, $this->aSquid->LogFqdn, 0, "checkbox")?>(**)</td>
			</tr>
			<tr>
				<td colspan="2">
				<p align="justify">(**) En lugar de almacenar los IPs de los sitios a los que se establece conexión, se almacenan sus nombres de dominio. 
				Sin embargo, esto puede provocar que sea más lento el navegar.
				</p>
				</td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	protected function cargarPagina4(){
		?>
		<fieldset>
			<legend>Habilitar Proxy Transparente</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>
				<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> Seleccione.la siguiente opción para habilitar la funcionalidad de Proxy Transparente</p>
				</td>
			</tr>
			</table>
			<br>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="210px"><label accesskey="t" for="chkTransparente"><u>H</u>abilitar proxy transparente:</label></td>
				<td><?=HTML::CheckBox("chkTransparente", 1, $this->aSquid->Transparent, 0, "checkbox")?>(**)</td>
			</tr>
			<tr>
				<td colspan="2">
				<p align="justify">(**) Utilice el módulo Iptables para habilitar el envío y recepción de paquetes a través del puerto seleccionado para el Squid.
				</p>
				</td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function cargarPagina5(){
		?>
		<fieldset>
			<legend>Finalizar la Configuración</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td colspan="2">
				<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> La guía para la configuración del Squid ha concluido.  Para guardar los cambios pulse sobre la opcion Guardar.</p>
				<p align="justify">Los cambios serán aplicados una vez se registren nuevas reglas a la configuración generada.</p>
				</td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
			
} // end of VistaAdministrarInterfaz
?>
