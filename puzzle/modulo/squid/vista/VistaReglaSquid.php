<?php
/**
 * @package /modulo/squid/vista/
 * @class VistaReglaSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR_SQUID.'ControladorReglaSquid.php';
require_once CLASES_SQUID.'Squid.php';
require_once CLASES_SQUID.'ReglaPredefinida.php';
require_once CLASES_SQUID.'ReglaSquid.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaReglaSquid extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aSquid = null;
	private $aListadoReglas = array();
	private $aReglasPredefinidas = array();
	private $aListasControlAcceso = array();
	private $aTiposRegla = array();
	
	/**
	* Constructor de la VistaInterfaz.
	*
	* @param controlador::ControladorInterfaz pControlador Controlador de la pantalla.
	* @return 
	* @access private
	*/
	public function __construct( $pControlador = null ) {
		$this->aControlador = $pControlador;
		$lEvento = "";
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
		}
		$this->aControlador->procesar($lEvento);
		
		$this->aSquid = $this->aControlador->getSquid();
		$this->aListadoReglas = $this->aControlador->getListadoReglas();
		$this->aReglasPredefinidas = $this->aControlador->getReglasPredefinidas();
		$this->aListasControlAcceso = $this->aControlador->getListasControlAcceso();
		$this->aTiposRegla = $this->aControlador->getTiposRegla();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=ReglaSquid&amp;Modulo=Squid";
		if (isset($_GET["Regla"])) {
			$lRegla = $_GET["Regla"];
			if (($lRegla == "Cache") or ($lRegla == "Predefinida") or ($lRegla == "Personalizada") or ($lRegla == "404")) {
				$lAccion .= "&amp;Regla=".$_GET["Regla"];
			} else {
				header("Location:index.php?Pagina=ReglaSquid&Regla=404");
			}
		}
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ReglaID","")?>
			<?=HTML::Hidden("Squid",$this->aSquid->ID)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Configuraci&oacute;n de las Reglas del Squid</h1></th></tr>
			<? if ($this->aSquid->ID > 0) { ?>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=ReglaSquid&amp;Modulo=Squid&amp;Regla=Cache">
						<img src="<?=IMAGENES_SQUID?>boton/nic.png" alt="[Caché]" title="Reglas de la Caché">&nbsp;Reglas de la Caché
						</a>
						&nbsp;
						<a href="index.php?Pagina=ReglaSquid&amp;Modulo=Squid&amp;Regla=Predefinida">
						<img src="<?=IMAGENES_SQUID?>boton/folder.png" alt="[Predefinidas]" title="Reglas Predefinidas">&nbsp;Reglas Predefinidas
						</a>
						&nbsp;
						<a href="index.php?Pagina=ReglaSquid&amp;Modulo=Squid&amp;Regla=Personalizada">
						<img src="<?=IMAGENES_SQUID?>boton/settings.png" alt="[Personalizadas]" title="Reglas Personalizadas">&nbsp;Reglas Personalizadas
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
								$lFuncion = "texto".(isset($_GET["Regla"])?$_GET["Regla"]:"Cache");
								$this->{$lFuncion}();
							?>
						</td>
					</tr>
					</table>
					<? 
					$lFuncion = "cargar".(isset($_GET["Regla"])?$_GET["Regla"]:"Cache");
					$this->{$lFuncion}();
					?>
				</td>
			</tr>
			<tr>
				<td align="right">
					<?=Html::Button("btnSalir", "Cancelar", 1, "button", "evtSalir()")?>
				</td>
			</tr>
			<? } else { ?>
			<tr>
				<td>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<p align="center" style="font-weight:normal;">
							<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> No se ha definido una configuración activa. 
							Para seleccionar una, acceda al siguiente <u><a href="index.php?Pagina=HistoricoSquid&amp;Modulo=Squid">enlace</a></u>.
							</p>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<? } ?>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido

	protected function textoCache(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla registre los tipos de archivos 
		que usted no desee sean almacenados en la caché del Squid.
		</p>
		<?
	}
	
	protected function cargarCache(){
		?>
		<fieldset>
			<legend>Configuración de la Regla</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td valign="top"><label accesskey="n" for="txtNombre"><u>N</u>ombre de la regla:</label></td>
				<td><?=HTML::ComboBox("cmbNombre", $this->aListasControlAcceso, "Nombre", "Nombre", 0, "", "combobox","evtSeleccionarNombre()")."&nbsp;".HTML::TextBox("txtNombre", "", 20, 20, 0, "textField")?></td>
			</tr>
			<tr>
				<td valign="top"><label>Aplicar a aquellos que:</label></td>
				<td><?=HTML::ComboBox("cmbTipo", $this->aTiposRegla, "ID", "Descripcion", 0, 0, "combobox")?></td>
			</tr>
			<tr>
				<td valign="top"><label accesskey="v" for="txtValores"><u>V</u>alores (Uno por línea):</label></td>
				<td><?=HTML::TextArea("txtValores", "", 3, 58, "on", 0, "textField")?></td>
			</tr>
			<tr>
				<td align="right" colspan="2">
					<?=Html::Button("btnAgregar", "Agregar", 1, "button", "evtAgregarRegla(0)")?>
				</td>
			</tr>
			</table>
		</fieldset>
		
		<fieldset>
			<legend>Reglas Sin Acción Definida</legend>
			<?
			$lHeader = array("N&deg;", "Nombre", "Tipo", "Valores", "");
			$lTabla = new Tabla($lHeader);
			$lNum = 0;
			foreach($this->aListadoReglas as $lReglaSquid) {
				if (($lReglaSquid->Accion->ID == 0) and ($lReglaSquid->TipoAcceso->Nombre == "no_cache")) {
					$lNum++;
					$lAccion = HTML::ImageButton("btnAplicar", IMAGENES_SQUID."boton/apply.png", "Aprobar Regla", 0, "", "evtAprobarRegla(".$lReglaSquid->ID.")")."&nbsp;";
					$lAccion .= HTML::ImageButton("btnDenegar", IMAGENES_SQUID."boton/deny.png", "Denegar Regla", 0, "", "evtDenegarRegla(".$lReglaSquid->ID.")")."&nbsp;";
					$lAccion .= HTML::ImageButton("btnRemover", IMAGENES_SQUID."boton/delete.png", "Remover Regla", 0, "", "evtRemoverRegla(".$lReglaSquid->ID.")");
					$lValores = "";
					foreach($lReglaSquid->ListaControlAcceso->Valores as $lValor) {
						$lValores .= $lValor->Nombre."<br>";
					}
					$lFila = array($lNum, $lReglaSquid->ListaControlAcceso->Nombre, $lReglaSquid->ListaControlAcceso->TipoACL->Descripcion, $lValores, $lAccion);
					$lTabla->addRow($lFila);
				}
			}
			echo $lTabla;
			?>
		</fieldset>
		
		<fieldset>
			<legend>Listado de Reglas</legend>
			<?
				$lHeader = array("N&deg;", "Nombre", "Tipo", "Valores", "Acción", "");
				$lTabla = new Tabla($lHeader);
				$lNum = 0;
				foreach($this->aListadoReglas as $lReglaSquid) {
					if (($lReglaSquid->Accion->ID > 0) and ($lReglaSquid->TipoAcceso->Nombre == "no_cache")) {
						$lValores = "";
						foreach($lReglaSquid->ListaControlAcceso->Valores as $lValor) {
							$lValores .= $lValor->Nombre."<br>";
						}
						$lNum++;
						$lEliminar = HTML::ImageButton("btnEliminar", IMAGENES_SQUID."boton/delete.png", "Eliminar Regla", 0, "", "evtEliminarRegla(".$lReglaSquid->ID.")");
						$lFila = array($lNum, $lReglaSquid->ListaControlAcceso->Nombre, $lReglaSquid->ListaControlAcceso->TipoACL->Descripcion, $lValores, $lReglaSquid->Accion->Descripcion, $lEliminar);
						$lTabla->addRow($lFila);
					}
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function textoPredefinida(){
		?>
		<p align="center">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede seleccionar los servicios que desea bloquear.
		</p>
		<?
	}
	
	protected function cargarPredefinida(){
		?>
		<fieldset>
			<legend>Reglas a Seleccionar</legend>
			<?
				$lHeader = array("N&deg;", "Nombre", "Descripción", "");
				$lTabla = new Tabla($lHeader, true);
				$lNum = 0;
				foreach($this->aReglasPredefinidas as $lReglaPredefinida) {
					$lNum++;
					$lAgregar = HTML::ImageButton("btnAgregar", IMAGENES_SQUID."boton/new.png", "Agregar Regla", 0, "", "evtAgregarRegla(".$lReglaPredefinida->ID.")");
					$lFila = array($lNum, $lReglaPredefinida->Nombre, $lReglaPredefinida->Descripcion, $lAgregar);
					$lTabla->addRow($lFila);
				}
				echo $lTabla;
			?>
		</fieldset>
		
		<fieldset>
			<legend>Listado de Reglas</legend>
			<?
				$lHeader = array("N&deg;", "Nombre", "Descripción", "");
				$lTabla = new Tabla($lHeader);
				$lNum = 0;
				foreach($this->aListadoReglas as $lReglaPredefinida) {
					$lNum++;
					$lEliminar = HTML::ImageButton("btnEliminar", IMAGENES_SQUID."boton/delete.png", "Eliminar Regla", 0, "", "evtEliminarRegla(".$lReglaPredefinida->ID.")");
					$lFila = array($lNum, $lReglaPredefinida->Nombre, $lReglaPredefinida->Descripcion, $lEliminar);
					$lTabla->addRow($lFila);
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function textoPersonalizada(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede registrar nuevas reglas que usted defina 
		para la funcionalidad de Proxy del Squid.
		</p>
		<?
	}
	
	protected function cargarPersonalizada(){
		?>
		<fieldset>
			<legend>Configuración de la Regla</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td valign="top"><label accesskey="n" for="txtNombre"><u>N</u>ombre:</label></td>
				<td><?=HTML::ComboBox("cmbNombre", $this->aListasControlAcceso, "Nombre", "Nombre", 0, "", "combobox","evtSeleccionarNombre()")."&nbsp;".HTML::TextBox("txtNombre", "", 20, 20, 0, "textField")?></td>
			</tr>
			<tr>
				<td valign="top"><label accesskey="t" for="cmbTipo"><u>T</u>ipo de Regla:</label></td>
				<td><?=HTML::ComboBox("cmbTipo", $this->aTiposRegla, "ID", "Descripcion", 0, 0, "combobox")?></td>
			</tr>
			<tr>
				<td valign="top"><label accesskey="v" for="txtValores"><u>V</u>alores (Uno por línea):</label></td>
				<td><?=HTML::TextArea("txtValores", "", 3, 58, "on", 0, "textField")?></td>
			</tr>
			<tr>
				<td align="right" colspan="2">
					<?=Html::Button("btnAgregar", "Agregar", 1, "button", "evtAgregarRegla(0)")?>
				</td>
			</tr>
			</table>
		</fieldset>
		
		<fieldset>
			<legend>Reglas Sin Acción Definida</legend>
			<?
			$lHeader = array("N&deg;", "Nombre", "Tipo", "", "");
			$lTabla = new Tabla($lHeader);
			$lNum = 0;
			foreach($this->aListadoReglas as $lReglaSquid) {
				if (($lReglaSquid->Accion->ID == 0) and ($lReglaSquid->TipoAcceso->Nombre == "http_access")) {
					$lValores = "";
					foreach($lReglaSquid->ListaControlAcceso->Valores as $lValor) {
						$lValores .= $lValor->Nombre."<br>";
					}
					$lNum++;
					$lAccion = HTML::ImageButton("btnAplicar", IMAGENES_SQUID."boton/apply.png", "Aprovar Regla", 0, "", "evtAprobarRegla(".$lReglaSquid->ID.")")."&nbsp;";
					$lAccion .= HTML::ImageButton("btnDenegar", IMAGENES_SQUID."boton/deny.png", "Denegar Regla", 0, "", "evtDenegarRegla(".$lReglaSquid->ID.")")."&nbsp;";
					$lAccion .= HTML::ImageButton("btnRemover", IMAGENES_SQUID."boton/delete.png", "Remover Regla", 0, "", "evtRemoverRegla(".$lReglaSquid->ID.")");
					$lFila = array($lNum, $lReglaSquid->ListaControlAcceso->Nombre, $lReglaSquid->ListaControlAcceso->TipoACL->Descripcion, $lValores, $lAccion);
					$lTabla->addRow($lFila);
				}
			}
			echo $lTabla;
			?>
		</fieldset>
		
		<fieldset>
			<legend>Listado de Reglas</legend>
			<?
			$lHeader = array("N&deg;", "Nombre", "Tipo", "", "Acción", "");
			$lTabla = new Tabla($lHeader);
			$lNum = 0;
			foreach($this->aListadoReglas as $lReglaSquid) {
				if (($lReglaSquid->Accion->ID > 0) and ($lReglaSquid->TipoAcceso->Nombre == "http_access")) {
					$lValores = "";
					foreach($lReglaSquid->ListaControlAcceso->Valores as $lValor) {
						$lValores .= $lValor->Nombre."<br>";
					}
					$lNum++;
					$lEliminar = HTML::ImageButton("btnEliminar", IMAGENES_SQUID."boton/delete.png", "Eliminar Regla", 0, "", "evtEliminarRegla(".$lReglaSquid->ID.")");
					$lFila = array($lNum, $lReglaSquid->ListaControlAcceso->Nombre, $lReglaSquid->ListaControlAcceso->TipoACL->Descripcion, $lValores, $lReglaSquid->Accion->Descripcion, $lEliminar);
					$lTabla->addRow($lFila);
				}
			}
			echo $lTabla;
			?>
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
