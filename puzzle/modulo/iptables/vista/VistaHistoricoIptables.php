<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES_IPTABLES.'HistoricoIptables.php';
require_once CONTROLADOR_IPTABLES.'ControladorHistoricoIptables.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaHistoricoIptables extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aHistoricoIptables = null;
	
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
		$this->aFechaFin = date("Ymd");
		$this->aBusqueda = (isset($_POST['Buscar']))?$_POST['Buscar']:false;
		
		if (isset($_POST['txtFechaInicio']) and $this->aBusqueda)
			$this->aFechaInicio = trim($_POST['txtFechaInicio']) != "" ? date("d-m-Y"):$_POST['FechaInicio'];
		if (isset($_POST['txtFechaFin']) and $this->aBusqueda)
			$this->aFechaFin = trim($_POST['txtFechaFin']) != "" ? "00-00-0000":$_POST['FechaFin'];
		
		$this->aHistoricoIptables = $this->aControlador->getHistoricosIptables();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=HistoricoIptables&amp;Modulo=Iptables";
		/*if ($this->aIptables->ID) {
			$lAccion .= "&amp;ID=".$this->aHistoricoIptables->ID;
		}*/
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Registro Histórico Iptables</h1></th></tr>
			<tr>
				<td>
					<fieldset>
					<legend>Filtros de Búsqueda</legend>
						<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
						<tr>
							<td>Fecha Creación Inicial: </td>
							<td><?=HTML::TextBox("txtFechaInicio", "", 10, 10, 1, "textField")?></td>
							<td>Fecha Creación Final: </td>
							<td><?=HTML::TextBox("txtFechaFin", "", 10, 10, 2, "textField")?></td>
							<td><?=HTML::Button("btnBuscar","Buscar",3,"button","evtBuscar()");?></td>
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
							$lHeader = array("N&deg;", "Descripcion", "Fecha/Hora Creación", "Fecha/Hora Aplicación","");
							$lTabla = new Tabla($lHeader);
							$lNum = 0;
							foreach ($this->aHistoricoIptables as $lHistorico) {
								$lNum++;
								
								$lExportar = HTML::ImageButton("btnEliminar",IMAGENES_IPTABLES."boton/db_update1.png","Exportar Reglas",0,"","evtExportar(".$lHistorico->ID.")");

								$lAplicar = HTML::ImageButton("btnAplicar",IMAGENES_IPTABLES."boton/iniciar.png","Aplicar Configuración",0,"","evtAplicar(".$lHistorico->ID.")");

								$lEliminar = HTML::ImageButton("eliminar",IMAGENES."boton/delete.png","Eliminar Subred",0,"","evtEliminar(".$lHistorico->ID.")");
								
								$lCreacion = date("d-m-Y",strtotime($lHistorico->FechaCreacion))."&nbsp;".$lHistorico->HoraCreacion;
								
								$lActivacion = "";
								foreach ($lHistorico->FechasActivacionIptables as $lFechaActivacion) {
									$lActivacion .= date("d-m-Y",strtotime($lFechaActivacion->FechaActivacion)). "&nbsp;" .$lFechaActivacion->HoraActivacion . "<br>";
								}
								
								$lLinea = array($lNum, $lHistorico->Descripcion, $lCreacion,$lActivacion, $lExportar."&nbsp;".$lAplicar."&nbsp;".$lEliminar);
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
