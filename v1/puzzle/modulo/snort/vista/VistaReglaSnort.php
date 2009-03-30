<?php
/**
 * @package /modulo/squid/vista/
 * @class VistaReglaSnort.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR_SNORT.'ControladorReglaSnort.php';
require_once CLASES_SNORT.'Snort.php';
require_once CLASES_SNORT.'ReglaPredefinida.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaReglaSnort extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aSnort = null;
	private $aListadoReglas = array();
	private $aReglasPredefinidas = array();
	
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
		
		$this->aSnort = $this->aControlador->getSnort();
		$this->aListadoReglas = $this->aControlador->getListadoReglas();
		$this->aReglasPredefinidas = $this->aControlador->getReglasPredefinidas();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=ReglaSnort&Modulo=Snort";
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ReglaID","")?>
			<?=HTML::Hidden("Snort",$this->aSnort->ID)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Configuraci&oacute;n de las Reglas del Snort</h1></th></tr>
			<? if ($this->aSnort->ID > 0) { ?>
			<tr>
				<td>
					<br>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<p align="center" style="font-weight:normal;">
							<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla registre los tipos de archivos 
							que usted no desee sean almacenados en la caché del Snort.
							</p>
						</td>
					</tr>
					</table>
					<fieldset>
						<legend>Reglas Sin Acción Definida</legend>
							<?
							$lHeader = array("N&deg;", "Nombre", "Descripcion", "");
							$lTabla = new Tabla($lHeader, true);
							$lNum = 0;
							foreach($this->aReglasPredefinidas as $lReglaSnort) {
								$lNum++;
								$lAccion = HTML::ImageButton("Agregar", IMAGENES_SNORT."boton/new.png", "Agregar Regla", 0, "", "evtAgregarRegla(".$lReglaSnort->ID.")")."&nbsp;";
								$lFila = array($lNum, $lReglaSnort->Nombre, $lReglaSnort->Descripcion, $lAccion);
								$lTabla->addRow($lFila);
							}
							echo $lTabla;
							?>
					</fieldset>
		
					<fieldset>
						<legend>Listado de Reglas</legend>
						<?
							$lHeader = array("N&deg;", "Nombre", "Descripcion", "");
							$lTabla = new Tabla($lHeader, true);
							$lNum = 0;
							foreach($this->aListadoReglas as $lReglaSnort) {
								$lNum++;
								$lAccion = HTML::ImageButton("btnEliminar", IMAGENES_SNORT."boton/delete.png", "Eliminar Regla", 0, "", "evtEliminarRegla(".$lReglaSnort->ID.")");
								$lFila = array($lNum, $lReglaSnort->Nombre, $lReglaSnort->Descripcion, $lAccion);
								$lTabla->addRow($lFila);
							}
							echo $lTabla;
						?>
					</fieldset>
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
							Para seleccionar una, acceda al siguiente <u><a href="index.php?Pagina=HistoricoSnort&amp;Modulo=Snort">enlace</a></u>.
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

} // end of VistaAdministrarInterfaz
?>
