<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaHistoricoSnort.php
 * @class vista/VistaHistoricoSnort.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES_SNORT.'HistoricoSnort.php';
require_once CONTROLADOR_SNORT.'ControladorHistoricoSnort.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaHistoricoSnort
 */
class VistaHistoricoSnort extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aHistoricoSnort = null;
	
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
		
		$this->aHistoricoSnort = $this->aControlador->getHistoricosSnort();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=HistoricoSnort&Modulo=Snort";
		/*if ($this->aSnort->ID) {
			$lAccion .= "&ID=".$this->aHistoricoSnort->ID;
		}*/
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Registro Histórico Snort</h1></th></tr>
			<tr>
				<td>
					<fieldset>
					<legend>Filtros de Búsqueda</legend>
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
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Registros</legend>
						<?
							$lHeader = array("N&deg;", "Descripción", "Creación", "Aplicación","");
							$lTabla = new Tabla($lHeader);
							$lNum = 0;
							foreach ($this->aHistoricoSnort as $lHistorico) {
								$lNum++;
								
								$lExportar = HTML::ImageButton("btnEliminar",IMAGENES_SNORT."boton/db_update1.png","Exportar Reglas",0,"","evtExportar(".$lHistorico->ID.")");

								$lAplicar = HTML::ImageButton("btnAplicar",IMAGENES_SNORT."boton/iniciar.png","Aplicar Configuración",0,"","evtAplicar(".$lHistorico->ID.")");

								$lEliminar = HTML::ImageButton("eliminar",IMAGENES."boton/delete.png","Eliminar Subred",0,"","evtEliminar(".$lHistorico->ID.")");

								$lCreacion = date("d-m-Y",strtotime($lHistorico->FechaCreacion))."&nbsp;".$lHistorico->HoraCreacion;
								
								$lActivacion = "";
								foreach ($lHistorico->FechasAplicacionSnort as $lFechaActivacion) {
									$lActivacion .= date("d-m-Y",strtotime($lFechaActivacion->FechaAplicacion)). "&nbsp;" .$lFechaActivacion->HoraAplicacion . "<br>";
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
