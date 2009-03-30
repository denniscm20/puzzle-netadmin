<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorAdministrarInterfaz.php
 * @class controlador/ControladorAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once 'modelo/clases/Interfaz.php';
require_once 'modelo/clases/Nodo.php';
require_once 'modelo/dao/DAOInterfaz.php';
require_once 'modelo/dao/DAONodo.php';
require_once 'modelo/dao/DAOSubred.php';
require_once 'modelo/clases/Subred.php';
require_once BASE.'Controlador.php';

/**
 * class ControladorAdministrarNodo
 * Controlador de la pantalla VistaControlador
 */
class ControladorAdministrarNodo extends Controlador {

	 /*** Attributes: ***/

	private $aNodo = null;
	private $aSubred = null;

	/**
	 * Permite obtener una instancia del objeto ControladorAdministrarInterfaz.
	 *
	 * @return controlador::ControladorAdministrarInterfaz
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorAdministrarNodo();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "guardar":
			case "eliminarNodo":
			case "eliminarSubred":
			case "agregarNodo":
			case "modificarNodo":
			case "obtenerHostname":
				$this->{$pEvento}();
				break;
		}
		
		$this->listarInterfacesPorServidor();
		$this->listarSubredes();
		$this->listarSubredesSinInterfaz();
		//$this->listarNodosSinClasificar();
	}
	
	/**
	 * Permite guardar los valores de un objeto Interfaz.
	 *
	 * @return bool
	 * @access public
	 */
	public function guardar( ) {
		
	} // end of member function guardar
	
	public function getNodo() {
		return $this->aNodo;
	}
	
	public function getSubred() {
		return $this->aSubred;
	}
	
	public function eliminarNodo( ) {
		try {
			$lNodo = new Nodo();
			$lNodo->ID = $_POST['NodoID'];
			$lDAONodo = new DAONodo($lNodo);
			if ($lDAONodo->eliminar()) {
				$_SESSION["info"] = "El registro ha sido eliminado exitosamente";
				return true;
			}
			$_SESSION["advertencia"] = "No se ha podido eliminar el registro";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarSubred( ) {
		try {
			$lSubred = new Subred();
			$lSubred->ID = $_POST['SubredID'];
			$lDAOSubred = new DAOSubred($lSubred);
			$lSubred = $lDAOSubred->buscarID();
			
			foreach ($lSubred->Nodos as $lNodo) {
				$lDAONodo = new DAONodo($lNodo);
				$lDAONodo->eliminar();
			}
			
			if ($lDAOSubred->eliminar()) {
				$_SESSION["info"] = "El registro ha sido eliminado exitosamente";
				return true;
			}
			$_SESSION["advertencia"] = "No se ha podido eliminar el registro";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregarNodo( ) {
		try {
			$lNodo = new Nodo();
			$lSubredID = $_POST['SubredID'];
			$lNodo->IP = $_POST["txtIPNodo".$lSubredID];
			$lNodo->Hostname = $_POST["txtHostnameNodo".$lSubredID];
			$lDAONodo = new DAONodo($lNodo);
			if ($lDAONodo->agregar($lSubredID)) {
				$_SESSION["info"] = "El registro ha sido agregado exitosamente";
				return true;
			}
			$_SESSION["advertencia"] = "No se ha podido agregar el registro";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function modificarNodo( ) {
		try {
			$lNodo = new Nodo();
			$lNodo->ID = $_POST['NodoID'];
			$lDAONodo = new DAONodo($lNodo);
			$lNodo = $lDAONodo->buscarID();
			
			$lDAONodo = new DAONodo($lNodo);
			if ($lDAONodo->modificar($_POST["cmbDestino".$lNodo->ID])){
				$_SESSION["info"] = "El registro ha sido actualizado exitosamente";
				return true;
			}
			$_SESSION["advertencia"] = "No se ha podido actualizar el registro";
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarInterfacesPorServidor( ) {
		$lServidorID = 1;
		$lDAOInterfaz = new DAOInterfaz(null);
		$lInterfaces = $lDAOInterfaz->listarPorServidor($lServidorID);
		
		return $lInterfaces;
	}
	
	public function obtenerHostname() {
		$this->aSubred->ID = $_POST['SubredID'];
		$this->aNodo->IP = trim($_POST["txtIPNodo".$this->aSubred->ID]);
		$this->aNodo->Hostname = gethostbyaddr($this->aNodo->IP);
	}
	
	public function listarSubredes() {
		$lDAOSubred = new DAOSubred(null);
		return $lDAOSubred->listarTodos();
	}

	/**
	 * Permite buscar una Interfaz de acuerdo a su ID.
	 *
	 * @return modelo::clases::Interfaz
	 * @access public
	 */
	public function buscarID( ) {
		
	} // end of member function buscarID


	public function listarSubredesSinInterfaz() {
		$lDAOSubred = new DAOSubred(null);
		return $lDAOSubred->listarSubredSinInterfaz();
	}
	
	/**
	 * Constructor del objeto ControladorAdministrarInterfaz.
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		$this->aNodo = new Nodo();
		$this->aSubred = new Subred();
	} // end of member function __construct



} // end of ControladorAdministrarInterfaz
?>
