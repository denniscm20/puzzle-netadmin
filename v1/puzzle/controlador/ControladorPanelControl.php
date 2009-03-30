<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorUsuario.php
 * @class controlador/ControladorUsuario.php
 * @author dennis
 * @version 1.0
 */

require_once 'modelo/clases/Usuario.php';
require_once 'modelo/dao/DAOUsuario.php';
require_once BASE.'Controlador.php';

/**
 * class ControladorUsuario
 * Controlador de la vista VistaUsuario
 */
class ControladorPanelControl extends Controlador {

	private function _construct() {
	}
	
	/**
	 * Obtiene una instancia de tipo ControladorUsuario
	 *
	 * @return controlador::ControladorUsuario
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorPanelControl();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
	}

} // end of ControladorUsuario

?>
