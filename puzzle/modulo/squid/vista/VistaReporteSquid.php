<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES_SQUID.'ReglaSquid.php';
require_once CONTROLADOR_SQUID.'ControladorReporteSquid.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaReporteSquid
 */
class VistaReporteSquid extends Vista {

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
		$lAccion = "index.php?Pagina=ReporteSquid&amp;Modulo=Squid";
		if (isset($_GET["Log"])) {
			$lLog = $_GET["Log"];
			if (($lLog == "Cache") or ($lLog == "Store") or ($lLog == "Access") or ($lLog == "404")) {
				$lAccion .= "&amp;Log=".$_GET["Log"];
			} else {
				header("Location:index.php?Pagina=ReglaSquid&amp;Modulo=Squid&amp;Log=404");
			}
		}
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Reporte Squid</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=ReporteSquid&amp;Modulo=Squid&amp;Log=Cache">
						<img src="<?=IMAGENES_SQUID?>boton/net.png" alt="[Caché]" title="Log de la Caché">&nbsp;Log de la Caché
						</a>
						&nbsp;
						<a href="index.php?Pagina=ReporteSquid&amp;Modulo=Squid&amp;Log=Store">
						<img src="<?=IMAGENES_SQUID?>boton/nodo.png" alt="[Store]" title="Log Store">&nbsp;Log Store
						</a>
						&nbsp;
						<a href="index.php?Pagina=ReporteSquid&amp;Modulo=Squid&amp;Log=Access">
						<img src="<?=IMAGENES_SQUID?>boton/nic.png" alt="[Acceso]" title="Log Acceso">&nbsp;Log Acceso
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<? 
					$lFuncion = "cargar".(isset($_GET["Log"])?$_GET["Log"]:"Cache");
					$this->{$lFuncion}();
					?>
				</td>
			</tr>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido
			
	protected function cargarCache(){
		?>
		<fieldset>
		<legend>Filtros de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="150px">Número de registros:</td>
				<td align="right" width="160px">
					<select class="combobox" name="cmbUltimos" tabindex="5" style="width:100px; text-align:center;">
						<option>10</option>
						<option>25</option>
						<option>50</option>
						<option>100</option>
					</select>
				</td>
				<td width="*" align="right"><?=HTML::Button("btnBuscar","Buscar",6,"button","evtBuscar()");?></td>
			</tr>
			</table>
		</fieldset>
		<fieldset>
		<legend>Registros</legend>
			<?  
				$lHeader = array("Fecha", "Registro");
				$lTabla = new Tabla($lHeader);
				$lIndice = 0;
				foreach ($this->aLineasReporte as $lRegistro) {
					$lFecha = date("d-m-Y H:i:s",strtotime($this->aFechasReporte[$lIndice]));
					$lIndice++;
					$lLinea = array($lFecha, $lRegistro);
					$lTabla->addRow($lLinea);
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function cargarStore(){
		?>
		<fieldset>
		<legend>Filtros de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="150px">Número de registros:</td>
				<td align="right" width="160px">
				<select class="combobox" name="cmbUltimos" tabindex="5" style="width:100px; text-align:center;">
				<option>10</option>
				<option>25</option>
				<option>50</option>
				<option>100</option>
				</select>
				</td>
				<td width="*" align="right"><?=HTML::Button("btnBuscar","Buscar",6,"button","evtBuscar()");?></td>
			</tr>
			</table>
		</fieldset>
		<fieldset>
		<legend>Registros</legend>
			<?
				$lHeader = array("Fecha", "Acción", "Estado", "Tipo", "MIME", "Método");
				$lTabla = new Tabla($lHeader);
				$lIndice = 0;
				foreach ($this->aLineasReporte as $lRegistro) {
					$lFecha = date("d-m-Y H:i:s",$this->aFechasReporte[$lIndice]);
					$lIndice++;
					$lLinea = array($lFecha, $lRegistro[0],$lRegistro[1],$lRegistro[2],$lRegistro[3],$lRegistro[4]);
					$lTabla->addRow($lLinea);
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function cargarAccess(){
		?>
		<fieldset>
		<legend>Filtros de Búsqueda</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="150px">Número de registros:</td>
				<td align="right" width="160px">
				<select class="combobox" name="cmbUltimos" tabindex="5" style="width:100px; text-align:center;">
				<option>10</option>
				<option>25</option>
				<option>50</option>
				<option>100</option>
				</select>
				</td>
				<td width="*" align="right"><?=HTML::Button("btnBuscar","Buscar",6,"button","evtBuscar()");?></td>
			</tr>
			</table>
		</fieldset>
		<fieldset>
		<legend>Registros</legend>
			<?
				$lHeader = array("Fecha", "Respuesta<br>Tiempo/Tamaño", "IP Origen", "Squid Request/<br>Http Status", "URL", "MIME");
				$lTabla = new Tabla($lHeader);
				$lIndice = 0;
				foreach ($this->aLineasReporte as $lRegistro) {
					$lFecha = date("d-m-Y H:i:s",$this->aFechasReporte[$lIndice]);
					$lEnlace = "<a href=\"".$lRegistro[4]."\" target=\"blank\">Enlace</a>";
					$lIndice++;
					$lLinea = array($lFecha, $lRegistro[0]."/".$lRegistro[3],$lRegistro[1],str_replace("/","/<br>",$lRegistro[2]),$lEnlace, $lRegistro[5]);
					$lTabla->addRow($lLinea);
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
} // end of VistaAdministrarInterfaz
?>
