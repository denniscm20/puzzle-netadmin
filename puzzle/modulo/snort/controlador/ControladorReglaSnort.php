<?php
/**
 * @package /controlador/
 * @class ControladorReglaSnort
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once CLASES_SNORT.'Snort.php';
require_once CLASES_SNORT.'ReglaPredefinida.php';
require_once DAO_SNORT.'DAOSnort.php';
require_once DAO_SNORT.'DAOReglaPredefinida.php';
require_once LIB.'File.php';

/**
 * @class ControladorSnort
 * Controlador de la pantalla VistaSnort
 */
class ControladorReglaSnort extends Controlador {

	private $aSnort = null;
	private $aListadoReglas = array();
	private $aReglasPredefinidas = array();
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorReglaSnort();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "salir":
			case "agregarRegla":
			case "eliminarRegla":
				$this->{$pEvento}();
				break;
		}
		$this->cargarObjeto();
		$this->cargarReferencias();
	}
	
	public function getSnort() {
		return $this->aSnort;
	}
	
	public function getListadoReglas() {
		return $this->aListadoReglas;
	}
	
	public function getReglasPredefinidas() {
		return $this->aReglasPredefinidas;
	}
	
	protected function salir() {
		try {
			header("Location: /index.php?Pagina=PanelControl");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
		
	
	protected function agregarRegla() {
		try {
			$this->aSnort->ID = $_POST["Snort"];

			$lReglaPredefinida = new ReglaPredefinida();
			$lReglaPredefinida->ID = $_POST['ReglaID'];
			$lDAOReglaPredefinida = new DAOReglaPredefinida($lReglaPredefinida);
			$lDAOReglaPredefinida->agregar($this->aSnort->ID);

		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function removerRegla() {
		try {
			$lACL = new ListaControlAcceso();
			$lACL->ID = $_POST["ReglaID"];
			$lDAOListaControlAcceso = new DAOListaControlAcceso($lACL);
			$lDAOListaControlAcceso->eliminar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarRegla() {
		try {
			$this->aSnort->ID = $_POST["Snort"];
			$lReglaPredefinida = new ReglaPredefinida();
			$lReglaPredefinida->ID = $_POST['ReglaID'];
			$lDAOReglaPredefinida = new DAOReglaPredefinida($lReglaPredefinida);
			$lDAOReglaPredefinida->eliminar($this->aSnort->ID);
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function cargarObjeto() {
		if (isset($_POST["Snort"]) and ($_POST["Snort"] > 0)) {
			$this->aSnort->ID = $_POST["Snort"];
			$lDAOSnort = new DAOSnort($this->aSnort);
			$this->aSnort = $lDAOSnort->buscarID();
		} else {
			try {
				$lDAOSnort = new DAOSnort();
				$this->aSnort = $lDAOSnort->buscarActivo();
			} catch (Exception $e) {
				$_SESSION["error"] = $e->getMessage();
			}
		}
	}
	
	protected function cargarReferencias( ) {
		try {
			$lDAOReglaPredefinida = new DAOReglaPredefinida();
			$this->aReglasPredefinidas = $lDAOReglaPredefinida->listarNoSnort($this->aSnort->ID);
			
			$this->aListadoReglas = $lDAOReglaPredefinida->listarSnort($this->aSnort->ID);
			
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	/**
	 * Contructor del objeto ControladorServidor
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		$this->aSnort = new Snort;
		$this->aListadoReglas = array();
		$this->aReglasPredefinidas = array();
	} // end of member function __construct

} // end of ControladorServidor
?>
