<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorAdministrarInterfaz.php
 * @class controlador/ControladorAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Interfaz.php';
require_once DAO.'DAOInterfaz.php';
require_once DAO.'DAOSubred.php';
require_once CLASES.'Subred.php';
require_once CONTROLADOR.'ControladorAdministrarInterfaz.php';
require_once BASE.'Controlador.php';


/**
 * class ControladorAdministrarInterfaz
 * Controlador de la pantalla VistaControlador
 */
class ControladorAdministrarInterfaz extends Controlador {

	 /*** Attributes: ***/

	/**
	 * Permite obtener una instancia del objeto ControladorAdministrarInterfaz.
	 *
	 * @return controlador::ControladorAdministrarInterfaz
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorAdministrarInterfaz();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "guardar":
			case "eliminar":
			case "listarPorServidor":
				$this->{$pEvento}();
				break;
		}
		
		$this->listarPorServidor();
	}
	
	/**
	 * Permite guardar los valores de un objeto Interfaz.
	 *
	 * @return bool
	 * @access public
	 */
	public function guardar( ) {
		
	} // end of member function guardar
			
	public function eliminar( ) {
		try {
			$lSubred = new Subred();
			$lSubred->ID = $_POST['SubredID'];
			$lDAOSubred = new DAOSubred($lSubred);
			if ($lDAOSubred->eliminar()) {
				$_SESSION["info"] = "El registro ha sido eliminado exitosamente";
				return true;
			}
			$_SESSION["advertencia"] = "No se ha podido eliminar el registro";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarPorServidor( ) {
		$lServidorID = 1;
		$lDAOInterfaz = new DAOInterfaz(null);
		$lInterfaces = $lDAOInterfaz->listarPorServidor($lServidorID);
		
		return $lInterfaces;
	}

	/**
	 * Constructor del objeto ControladorAdministrarInterfaz.
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		
	} // end of member function __construct



} // end of ControladorAdministrarInterfaz
?>
