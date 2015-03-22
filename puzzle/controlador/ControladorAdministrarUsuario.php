<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorAdministrarUsuario.php
 * @class controlador/ControladorAdministrarUsuario.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Usuario.php';
require_once DAO.'DAOUsuario.php';
require_once BASE.'Controlador.php';

/**
 * @class ControladorAdministrarUsuario
 * Controlador de la vista VistaAdministrarUsuario
 */
class ControladorAdministrarUsuario extends Controlador {

	 /*** Attributes: ***/

	/**
	 * Conjunto de Usuarios
	 * @access private
	 */
	private $aUsuarios = array();

	/**
	* Constructor de la clase
	*
	* @return 
	* @access private
	*/
	private function __construct( ) {
		$this->aUsuarios = array();
	} // end of member function __construct
	
	/**
	 * Obtiene una instancia de tipo ControladorUsuario
	 *
	 * @return controlador::ControladorUsuario
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorAdministrarUsuario();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "eliminar":
				$this->{$pEvento}();
				break;
		}
		
		$this->listarTodos();
	}
			
	/**
	 * Permite eliminar los datos de un usuario registrado
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$lID = $_POST['UsuarioID']; 
			$lUsuario = new Usuario();
			$lUsuario->ID = $lID;
			$lDAOUsuario = new DAOUsuario($lUsuario);
			$lUsuario = $lDAOUsuario->buscarID();
			if ( $lDAOUsuario->eliminar()) {
				$_SESSION["info"] = "El registro ha sido eliminado exitosamente";
				// Mensaje Log
				return true;
			}
			$_SESSION["advertencia"] = "No se ha podido eliminar el registro";
			return false;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminarUsuario

	/**
	 * Permite buscar todos los usuarios que cumplan con el criterio de búsqueda.
	 *
	 * @return array
	 * @access public
	 */
	public function buscar( ) {
	} // end of member function buscarUsuario
			
	/**
	 * Lista todos los usuarios registrados en la aplicación.
	 *
	 * @return array
	 * @access public
	 */
	public function listarTodos() {
		$lDAOUsuario = new DAOUsuario(null);
		$this->aUsuarios =  $lDAOUsuario->listarTodos();
		return $this->aUsuarios;
	}
	
	public function getUsuario( $pIndice) {
		if (count($this->aUsuarios)< $pIndice) {
			return $this->aUsuarios[$pIndice];
		} else {
			return new Usuario();
		}
	}
	

} // end of ControladorUsuario
?>
