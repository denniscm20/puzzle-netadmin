<?php
/**
 * @package /controlador/
 * @class ControladorAdministrarCuenta.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once CLASES.'Usuario.php';
require_once DAO.'DAOUsuario.php';

/**
 * @class ControladorAdministrarCuenta
 * Controlador de la vista VistaUsuario
 */
class ControladorAdministrarCuenta
{

	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private static $aControlador = null;

	/**
	* Constructor de la clase
	*
	* @return 
	* @access private
	*/
	private function __construct( ) {
	} // end of member function __construct
	
	/**
	 * Obtiene una instancia de tipo ControladorAdministrarCuenta
	 *
			* @return controlador::ControladorAdministrarCuenta
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorAdministrarCuenta();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

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
					header("Location: index.php?Pagina=AdministrarUsuario");
					return true;
				}
			} else {
				if ($lDAOUsuario->modificar()) {
					$_SESSION["info"] = "El registro se ha guardado exitosamente.";
					$_SESSION["usuario"] = $lUsuario;
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
		header("Location: index.php?Pagina=PanelControl");
	}
	
	/**
	 * Permite buscar todos los usuarios que cumplan con el criterio de búsqueda.
	 *
	 * @return array
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$lID = $_GET['ID'];
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
