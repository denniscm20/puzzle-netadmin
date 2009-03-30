<?php
/**
 * @package /controlador/
 * @class ControladorAdministrarCuenta.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once(BASE."Controlador.php");
require_once CLASES.'Usuario.php';
require_once DAO.'DAOUsuario.php';

/**
 * @class ControladorAdministrarCuenta
 * Controlador de la vista VistaUsuario
 */
class ControladorAdministrarCuenta extends Controlador
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

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "guardar":
			case "cancelar":
				$this->{$pEvento}();
				break;
		}
		$this->listar();
	}
	
	/**
	 * Permite guardar los datos de un usuario.
	 *
	 * @return bool
	 * @access public
	 */
	public function guardar( ) {
		try {
			echo $lID = trim($_POST['ID']);
			echo $lNombre = trim($_POST['usuario']);
			echo $lPassword = trim($_POST['txtPassword']);
			echo $lConfirmacion = trim($_POST['txtConfirmacion']);
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
			
			if ($lDAOUsuario->modificar()) {
				$_SESSION["info"] = "El registro se ha guardado exitosamente.";
				$_SESSION["usuario"] = serialize($lUsuario);
				return true;
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

} // end of ControladorUsuario
?>
