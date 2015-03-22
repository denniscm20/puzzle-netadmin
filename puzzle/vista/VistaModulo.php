<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaModulo.php
 * @class vista/VistaModulo.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR.'ControladorModulo.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaModulo
 */
class VistaModulo extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aModulos = null;

	/**
	* Constructor de la VistaModulo.
	*
	* @param controlador::ControladorModulo pControlador Controlador de la pantalla.
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
		
		$this->aModulos = $this->aControlador->getModulos();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaModulo
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
	?>
		<form id="ActionForm" name="ActionForm" action="index.php?Pagina=Modulo" method="POST">
			<?php echo HTML::Hidden("Evento","")?>
			<?php echo HTML::Hidden("ID","")?>
			<?php echo HTML::Hidden("ServidorID",1)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Módulos Registrados</h1></th></tr>
			<tr>
				<td>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<p align="justify">
								<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> Para registrar nuevos módulos en la aplicación agregue el nuevo módulo al directorio 
								<strong>modulo</strong> y su respectivo archivo de configuración al directorio <strong>config</strong>.
							</p>
						</td>
					</tr>
					</table>
					<br>
					<?
						$lHeader = array("Modulo", "Estado de la Aplicación", "Estado del Módulo"); 
						$lTabla = new Tabla($lHeader);
						foreach ($this->aModulos as $lModulo) {
							$lLinea = array(ucfirst($lModulo["Modulo"]), ucwords($lModulo["EstadoAplicacion"]), ucwords($lModulo["EstadoModulo"]));
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


} // end of VistaModulo
?>
