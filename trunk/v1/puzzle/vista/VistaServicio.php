<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaServicio.php
 * @class vista/VistaServicio.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR.'ControladorServicio.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaServicio
 */
class VistaServicio extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aServicios = null;

	/**
	* Constructor de la VistaServicio.
	*
	* @param controlador::ControladorServicio pControlador Controlador de la pantalla.
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
		
		$this->aServicios = $this->aControlador->getServicios();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaServicio
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
	?>
		<form id="ActionForm" name="ActionForm" action="index.php?Pagina=Servicio" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("Servicio","")?>
			<?=HTML::Hidden("ServidorID",1)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Administrar Servicios</h1></th></tr>
			<tr>
				<td>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<p align="justify">
								<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> Para registrar nuevos servicios proceda a instalar la aplicación correspondiente.
							</p>
						</td>
					</tr>
					</table>
					<br>
					<?
						$lHeader = array("Servicio", "Estado", "Acciones"); 
						$lTabla = new Tabla($lHeader);
						$lCount = count($this->aServicios);
						for ($i = 0; $i < $lCount; $i++) {
							$lAccion = "";
							$lServicio = $this->aServicios[$i];
							switch ($lServicio["Iniciado"]) {
								case -1: $lAccion = "Revise la configuración del módulo"; break;
								case 0: $lAccion = HTML::ImageButton("btnDetener", $pSrc = IMAGENES."boton/detener.png", "Detener", 0, "", "evtDetener(".$i.")")."&nbsp;".HTML::ImageButton("btnReiniciar", $pSrc = IMAGENES."boton/reiniciar.png", "Reiniciar", 0, "", "evtReiniciar(".$i.")"); break;
								case 1: $lAccion = HTML::ImageButton("btnIniciar", $pSrc = IMAGENES."boton/iniciar.png", "Iniciar", 0, "", "evtIniciar(".$i.")"); break;
							}
							$lLinea = array(ucfirst($lServicio["Servicio"]), ucwords($lServicio["EstadoServicio"]),$lAccion);
							$lTabla->addRow($lLinea);
						}
						echo $lTabla;
					?>
				</td>
			</tr>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido


} // end of VistaServicio
?>
