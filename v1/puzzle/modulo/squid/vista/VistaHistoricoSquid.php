<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES_SQUID.'HistoricoSquid.php';
require_once CONTROLADOR_SQUID.'ControladorHistoricoSquid.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaHistoricoSquid extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aHistoricoSquid = null;
	
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
		
		$this->aHistoricoSquid = $this->aControlador->getHistoricosSquid();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=HistoricoSquid&amp;Modulo=Squid";
		/*if ($this->aSquid->ID) {
			$lAccion .= "&amp;ID=".$this->aHistoricoSquid->ID;
		}*/
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Registro Histórico Squid</h1></th></tr>
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
							foreach ($this->aHistoricoSquid as $lHistorico) {
								$lNum++;
								
								$lExportar = HTML::ImageButton("btnEliminar",IMAGENES_SQUID."boton/db_update1.png","Exportar Reglas",0,"","evtExportar(".$lHistorico->ID.")");

								$lAplicar = HTML::ImageButton("btnAplicar",IMAGENES_SQUID."boton/iniciar.png","Aplicar Configuración",0,"","evtAplicar(".$lHistorico->ID.")");

								$lEliminar = HTML::ImageButton("eliminar",IMAGENES."boton/delete.png","Eliminar Subred",0,"","evtEliminar(".$lHistorico->ID.")");

								$lCreacion = date("d-m-Y",strtotime($lHistorico->FechaCreacion))."&nbsp;".$lHistorico->HoraCreacion;
								
								$lActivacion = "";
								foreach ($lHistorico->FechasActivacionSquid as $lFechaActivacion) {
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
