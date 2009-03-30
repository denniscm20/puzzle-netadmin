<?php
/**
 * @package /controlador/
 * @class ControladorUsuario.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once CLASES.'Usuario.php';
require_once DAO.'DAOUsuario.php';
require_once BASE.'Controlador.php';

/**
 * @class ControladorUsuario
 * Controlador de la vista VistaUsuario
 */
class ControladorUsuario extends Controlador
{

	/*** Attributes: ***/

	/**
	* Constructor de la clase
	*
	* @return 
	* @access private
	*/
	private function __construct( ) {
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
			self::$aControlador = new ControladorUsuario();
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
	
	/**
	 * Permite guardar los datos de un usuario.
	 *
	 * @return bool
	 * @access public
	 */
	public function guardar( ) {
		try {
			$lID = trim($_POST['ID']);
			$lNombre = trim($_POST['usuario']);
			$lPassword = trim($_POST['password']);
			$lConfirmacion = trim($_POST['confirmacion']);
			if ($lNombre == "") {
				$_SESSION["advertencia"] = "El Usuario no puede ser un campo vacío.";
				return false;
			}
			if ($lPassword == "") {
				$_SESSION["advertencia"] = "El Password no puede ser un campo vacío.";
				return false;
			}
			if ($lPassword != $lConfirmacion) {
				$_SESSION["advertencia"] = "La contrase&ntilde;a y su confirmaci&oacute;n deben de ser iguales.";
				return false;
			}

			$lUsuario = new Usuario($lNombre,hash('sha512', $lPassword));
			$lUsuario->ID = $lID;
			$lDAOUsuario = new DAOUsuario($lUsuario);
			
			if ($lID == 0) {
				$lUsuarios = $lDAOUsuario->buscarPorNombre();
				if (count($lUsuarios) > 0) {
					$_SESSION["advertencia"] = "Ya existe un usuario registrado con ese nombre.";
					return false;
				}
				
				if ($lDAOUsuario->agregar()) {
					$_SESSION["info"] = "El registro se ha guardado exitosamente.";
					// Registrar Log
					session_write_close();
					header("Location: index.php?Pagina=AdministrarUsuario");
					return true;
				}
			} else {
				if ($lDAOUsuario->modificar()) {
					$_SESSION["info"] = "El registro se ha guardado exitosamente.";
					// Registrar Log
					session_write_close();
					header("Location: index.php?Pagina=AdministrarUsuario");
					return true;
				}
			}
			$_SESSION["error"] = "Se produjo un error en la base de datos.";
			return false;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function agregarUsuario

	public function cancelar() {
		header("Location: index.php?Pagina=AdministrarUsuario");
	}
	
	/**
	 * Permite buscar todos los usuarios que cumplan con el criterio de búsqueda.
	 *
	 * @return array
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$lID = isset($_GET['ID'])?$_GET['ID']:0;
			$lUsuario = new Usuario();
			$lUsuario->ID = $lID;
			$lDAOUsuario = new DAOUsuario($lUsuario);
			return $lDAOUsuario->buscarID();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function buscarUsuario
	

} // end of ControladorUsuario
?>
