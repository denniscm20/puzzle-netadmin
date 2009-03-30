<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES_SNORT.'ReglaPredefinida.php';
require_once CONTROLADOR_SNORT.'ControladorReporteSnort.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaReporteSnort
 */
class VistaReporteSnort extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aLineasReporte = null;
	
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
				
		$this->aLineasReporte = $this->aControlador->getLineasReporte();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=ReporteSnort&Modulo=Snort";
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Registro Histórico Snort</h1></th></tr>
			<tr>
				<td>
					<? 
					$lFuncion = "cargarAlertas";
					$this->{$lFuncion}();
					?>
				</td>
			</tr>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido
			
	protected function cargarAlertas(){
		?>
		<fieldset>
		<legend>Filtros de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="150px">Origen [IP* : Puerto]:</td>
				<td width="160px" align="right"><?=HTML::TextBox("txtIPOrigen", "", 15, 15, 3, "textField")?></td>
				<td width="*" align="left">&nbsp;:&nbsp;<?=HTML::TextBox("txtPuertoOrigen", "", 6, 6, 4, "textField")?></td>
			</tr>
			<tr>
				<td>Destino [IP* : Puerto]:</td>
				<td align="right"><?=HTML::TextBox("txtIPDestino", "", 15, 15, 5, "textField")?></td>
				<td align="left">&nbsp;:&nbsp;<?=HTML::TextBox("txtPuertoDestino", "", 6, 6, 6, "textField")?></td>
			</tr>
			<tr>
				<td>Número de registros:</td>
				<td align="right">
					<select class="combobox" name="cmbUltimos" tabindex="7" style="width:100px; text-align:center;">
						<option>10</option>
						<option>25</option>
						<option>50</option>
						<option>100</option>
					</select>
				</td>
				<td align="right"><?=HTML::Button("btnBuscar","Buscar",8,"button","evtBuscar()");?></td>
			</tr>
			</table>
		</fieldset>
		<fieldset>
		<legend>Registros</legend>
			<?
				$lHeader = array("Fecha", "Mensaje", "Datos Adicionales");
				$lTabla = new Tabla($lHeader);
				$lIndice = 0;
				foreach ($this->aLineasReporte as $lRegistro) {
					$lLinea = array($lRegistro["Fecha"], $lRegistro["Mensaje"], $lRegistro["Informacion"]);
					$lTabla->addRow($lLinea);
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
} // end of VistaAdministrarInterfaz
?>
