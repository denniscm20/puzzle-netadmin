<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorLogin.php
 * @class controlador/ControladorLogin.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Usuario.php';
require_once DAO.'DAOUsuario.php';
require_once DAO.'DAOIPv4Valida.php';
require_once DAO.'DAORegistroHistorico.php';
require_once CLASES.'RegistroHistorico.php';
require_once BASE.'Controlador.php';

/**
 * @class ControladorLogin
 * Controlador de la vista VistaLogin
 */
class ControladorLogin extends Controlador {

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
			self::$aControlador = new ControladorLogin();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "iniciarSesion":
				$this->{$pEvento}();
				break;
		}
		
		$this->listar();
	}
	
	/**
	 * Permite validar que el nombre y contraseña del usuario sean los adecuados.
	 *
	 * @return modelo::clases::Usuario
	 * @access public
	 */
	public function iniciarSesion( ) {
		$lNombre = trim($_POST["txtUsuario"]);
		$lPassword = $_POST["txtPassword"];
		//$lPassword = hash('sha512', trim($_POST["txtPassword"]));
		$lUsuario = new Usuario($lNombre, $lPassword);
		$lDAOUsuario = new DAOUsuario($lUsuario);
		$this->aUsuarios =  $lDAOUsuario->buscar();
		if ($this->aUsuarios != null) {
			$lRegistroHistorico = new RegistroHistorico($lNombre, "El usuario ".$lUsuario->Nombre." ha iniciado sesión satisfactoriamente");
			$lDAORegistroHistorico = new DAORegistroHistorico($lRegistroHistorico);
			$lDAORegistroHistorico->agregar();
			return $this->aUsuarios[0];
		}
		$lRegistroHistorico = new RegistroHistorico($lNombre, "Se ha intentando iniciar sesión con el usuario ".$lUsuario->Nombre);
		$lDAORegistroHistorico = new DAORegistroHistorico($lRegistroHistorico);
		$lDAORegistroHistorico->agregar();
		return null;
	} // end of member function validarUsuario

	
	public function getUsuario() {
		if (count($this->aUsuarios)) {
			return $this->aUsuarios[0];
		} else {
			return null;
		}
	}
	
	public function accesoNoAutorizado() {
		$lRegistroHistorico = new RegistroHistorico("desconocido", "Se ha intentado acceder a la aplicación desde un equipo no autorizado");
		$lDAORegistroHistorico = new DAORegistroHistorico($lRegistroHistorico);
		$lDAORegistroHistorico->agregar();
	}
	
	/**
	* Permite listar las direcciones IP Válidas.
	* @param int pIPValida
	* @return bool
	* @access public
	*/
	public function esIPValida( $pIPValida ) {
		try {
			$lDAOIPv4Valida = new DAOIPv4Valida(null);
			return (count($lDAOIPv4Valida->buscarPorIP($pIPValida)) > 0);
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function esIPValida

} // end of ControladorUsuario
?>
