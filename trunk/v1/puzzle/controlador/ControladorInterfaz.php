<?php
/**
 * @package /controlador/
 * @class ControladorServidor
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once CLASES.'Interfaz.php';
require_once DAO.'DAOInterfaz.php';
require_once LIB.'validator.php';
require_once BASE.'Controlador.php';

/**
 * @class ControladorServidor
 * Controlador de la pantalla VistaServidor
 */
class ControladorInterfaz extends Controlador {

	/*** Attributes: ***/

	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorInterfaz();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia
	
	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "guardar":
			case "cancelar":
				$this->{$pEvento}();
				break;
		}
		
		$this->buscarID();
	}
	
	public function cancelar( ) {
		header("Location: index.php?Pagina=AdministrarInterfaz");
	}

	/**
	 * Permite eliminar una dirección IP.
	 *
	 * @return bool
	 * @access public
	*/
	public function guardar( ) {
		try {
			$lInterfaz = new Interfaz();
			$lInterfaz->ID = $_POST['ID'];
			$lDAOInterfaz = new DAOInterfaz($lInterfaz);
			$lInterfaz = $lDAOInterfaz->buscarID();
			$lInterfaz->Descripcion = $_POST['txtDescripcion'];
			$lInterfaz->Internet = isset($_POST['chkInternet']);
			
			$lDAOInterfaz = new DAOInterfaz($lInterfaz);
			if ($lDAOInterfaz->modificar()) {
				$_SESSION["info"] = "El registro se ha guardado exitosamente.";
				session_write_close();
				header("Location: index.php?Pagina=AdministrarInterfaz");
				return true;
			}
			$_SESSION["error"] = "Se produjo un error en la base de datos.";
			return false;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function eliminar

	/**
	 * Permite buscar la información de un servidor de acuerdo a su ID.
	 *
	 * @return 
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$lInterfaz = new Interfaz();
			$lInterfaz->ID = $_GET['ID'];
			$lDAOInterfaz = new DAOInterfaz($lInterfaz);
			$lInterfaz = $lDAOInterfaz->buscarID();
			return $lInterfaz;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function buscarID


	/**
	 * Contructor del objeto ControladorServidor
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		
	} // end of member function __construct

} // end of ControladorServidor
?>
