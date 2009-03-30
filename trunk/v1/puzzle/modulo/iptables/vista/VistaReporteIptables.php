<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once CONTROLADOR_IPTABLES.'ControladorReporteIptables.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaReporteIptables
 */
class VistaReporteIptables extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aLineasReporte = null;
	private $aFechasReporte = null;
	
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
		$this->aFechasReporte = $this->aControlador->getFechasReporte();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=ReporteIptables&amp;Modulo=Iptables";
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Reporte Iptables</h1></th></tr>
			<tr>
				<td>
					<fieldset>
					<legend>Filtros de Búsqueda</legend>
						<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
						<tr>
							<td width="150px">Origen [IP : Puerto]:</td>
							<td width="160px" align="right"><?=HTML::TextBox("txtIPOrigen", "", 15, 15, 3, "textField")?></td>
							<td width="*" align="left">&nbsp;:&nbsp;<?=HTML::TextBox("txtPuertoOrigen", "", 6, 6, 2, "textField")?></td>
						</tr>
						<tr>
							<td>Destino [IP : Puerto]:</td>
							<td align="right"><?=HTML::TextBox("txtIPDestino", "", 15, 15, 3, "textField")?></td>
							<td align="left">&nbsp;:&nbsp;<?=HTML::TextBox("txtPuertoDestino", "", 6, 6, 2, "textField")?></td>
						</tr>
						<tr>
							<td>Número de registros:</td>
							<td align="right">
								<select class="combobox" name="cmbUltimos" tabindex="5" style="width:100px; text-align:center;">
									<option>10</option>
									<option>25</option>
									<option>50</option>
									<option>100</option>
								</select>
							</td>
							<td align="right"><?=HTML::Button("btnBuscar","Buscar",6,"button","evtBuscar()");?></td>
						</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Registros</legend>
						<?
							$lHeader = array("Fecha", "Interfaz Entrada", "Interfaz Salida", "IP Origen","IP Destino","Puerto Origen","Puerto Destino");
							$lTabla = new Tabla($lHeader);
							$lIndice = 0;
							foreach ($this->aLineasReporte as $lReglaIptables) {
								$lFecha = $this->aFechasReporte[$lIndice];
								$lFecha = date("d M H:i:s", strtotime($lFecha));
								$lIndice++;
								$lLinea = array($lFecha, $lReglaIptables->InterfazOrigen->Nombre, $lReglaIptables->InterfazDestino->Nombre, $lReglaIptables->IPOrigen, $lReglaIptables->IPDestino, $lReglaIptables->PuertoOrigenInicial, $lReglaIptables->PuertoDestinoInicial);
								$lTabla->addRow($lLinea);
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
} // end of VistaAdministrarInterfaz
?>
