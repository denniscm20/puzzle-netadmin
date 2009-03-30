<?php
/**
 * @package /controlador/
 * @class ControladorReglaSquid
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once CLASES_SQUID.'Squid.php';
require_once CLASES_SQUID.'ReglaPredefinida.php';
require_once DAO_SQUID.'DAOSquid.php';
require_once DAO_SQUID.'DAOTipoACL.php';
require_once DAO_SQUID.'DAOListaControlAcceso.php';
require_once DAO_SQUID.'DAOReglaPredefinida.php';
require_once LIB.'File.php';

/**
 * @class ControladorSquid
 * Controlador de la pantalla VistaSquid
 */
class ControladorReglaSquid extends Controlador {

	private $aSquid = null;
	private $aListadoReglas = array();
	private $aReglasPredefinidas = array();
	private $aListasControlAcceso = array();
	
	private $aTiposRegla = array();
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorReglaSquid();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "salir":
			case "agregarRegla":
			case "eliminarRegla":
			case "aprobarRegla":
			case "denegarRegla":
			case "removerRegla":
				$this->{$pEvento}();
				break;
		}
		$this->cargarObjeto();
		$this->cargarReferencias();
	}
	
	public function getSquid() {
		return $this->aSquid;
	}
	
	public function getListadoReglas() {
		return $this->aListadoReglas;
	}
	
	public function getReglasPredefinidas() {
		return $this->aReglasPredefinidas;
	}
	
	public function getListasControlAcceso () {
		return $this->aListasControlAcceso;
	}
	
	public function getTiposRegla() {
		return $this->aTiposRegla;
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
			$lReglaSquid = new ReglaSquid();
			$lReglaSquid->TipoAcceso->Nombre = "http_access";
			
			$this->aSquid->ID = $_POST["Squid"];
			$lRegla = $lRegla = isset($_GET["Regla"])?trim($_GET["Regla"]):"Cache";
			switch ($lRegla) {
				case "Predefinida":
					$lReglaPredefinida = new ReglaPredefinida();
					$lReglaPredefinida->ID = $_POST['ReglaID'];
					$lDAOReglaPredefinida = new DAOReglaPredefinida($lReglaPredefinida);
					$lDAOReglaPredefinida->agregar($this->aSquid->ID);
					
					require_once DAO_IPTABLES."DAOReglaPredefinida.php";
					$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables();
					$lDAOReglaPredefinida->agregarRegla($lReglaPredefinida->ID);
					break;
				case "Cache":
					$lReglaSquid->TipoAcceso->Nombre = "no_cache";
				case "Personalizada":
					$lDAOTipoAcceso = new DAOTipoAcceso($lReglaSquid->TipoAcceso);
					$lReglaSquid->TipoAcceso = $lDAOTipoAcceso->buscarNombre();
					$lDAOReglaSquid = new DAOReglaSquid($lReglaSquid);
					$lDAOReglaSquid->agregar($this->aSquid->ID);
					$lReglaSquid = $lDAOReglaSquid->buscarMaxID();
					
					$lACL = new ListaControlAcceso();
					$lACL->Nombre = $_POST["txtNombre"];
					$lACL->TipoACL->ID = $_POST["cmbTipo"];
					$lValores = array();
					$lValores = explode("\n",preg_replace("/\n$/", '', $_POST["txtValores"]));
					$lDAOListaControlAcceso = new DAOListaControlAcceso($lACL);
					$lDAOListaControlAcceso->agregar($lReglaSquid->ID);
					
					$lACL = $lDAOListaControlAcceso->buscarMaxID();
					
					foreach ($lValores as $lNombreValor) {
						$lValor = new Valor(trim($lNombreValor));
						$lDAOValor = new DAOValor($lValor);
						$lDAOValor->agregar($lACL->ID);
					}
					break;
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function removerRegla() {
		try {
			$lReglaSquid = new ReglaSquid();
			$lReglaSquid->ID = $_POST["ReglaID"];
			$lDAOReglaSquid = new DAOReglaSquid($lReglaSquid);
			$lReglaSquid = $lDAOReglaSquid->buscarID();
			
			$lDAOValor = new DAOValor(null);
			$lDAOValor->eliminarPorListaControlAcceso($lReglaSquid->ListaControlAcceso->ID);
			
			$lDAOListaControlAcceso = new DAOListaControlAcceso($lReglaSquid->ListaControlAcceso);
			$lDAOListaControlAcceso->eliminar();
			
			$lDAOReglaSquid->eliminarCompletamente();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarRegla() {
		try {
			$this->aSquid->ID = $_POST["Squid"];
			$lRegla = isset($_GET["Regla"])?trim($_GET["Regla"]):"Cache";
			switch ($lRegla) {
				case "Predefinida":
					$lReglaPredefinida = new ReglaPredefinida();
					$lReglaPredefinida->ID = $_POST['ReglaID'];
					$lDAOReglaPredefinida = new DAOReglaPredefinida($lReglaPredefinida);
					$lDAOReglaPredefinida->eliminar($this->aSquid->ID);
					break;
				case "Cache":
				case "Personalizada":
					$lReglaSquid = new ReglaSquid();
					$lReglaSquid->ID = $_POST["ReglaID"];
					$lDAOReglaSquid = new DAOReglaSquid($lReglaSquid);
					$lDAOReglaSquid->eliminar();
					break;
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function aprobarRegla() {
		try {
			$this->actualizarRegla("allow");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function denegarRegla() {
		try {
			$this->actualizarRegla("deny");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	private function actualizarRegla($pNombreAccion) {
		try {
			$this->aSquid->ID = $_POST["Squid"];
			$lRegla = isset($_GET["Regla"])?trim($_GET["Regla"]):"Cache";
			$lReglaID = trim($_POST["ReglaID"]);
			
			$lAccion = new Accion();
			$lAccion->Nombre = $pNombreAccion;
			$lDAOAccion = new DAOAccion($lAccion);
			
			$lReglaSquid = new ReglaSquid();
			$lReglaSquid->ID = $lReglaID;
			$lDAOReglaSquid = new DAOReglaSquid($lReglaSquid);
			$lReglaSquid = $lDAOReglaSquid->buscarID();
			
			$lReglaSquid->Accion = $lDAOAccion->buscarNombre();
			$lDAOReglaSquid = new DAOReglaSquid($lReglaSquid);
			$lDAOReglaSquid->actualizar();

		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function cargarObjeto() {
		if (isset($_POST["Squid"]) and ($_POST["Squid"] > 0)) {
			$this->aSquid->ID = $_POST["Squid"];
			$lDAOSquid = new DAOSquid($this->aSquid);
			$this->aSquid = $lDAOSquid->buscarID();
		} else {
			try {
				$lDAOSquid = new DAOSquid();
				$this->aSquid = $lDAOSquid->buscarActivo();
			} catch (Exception $e) {
				$_SESSION["error"] = $e->getMessage();
			}
		}
		
		$lRegla = isset($_GET["Regla"])?trim($_GET["Regla"]):"Cache";
		switch ($lRegla) {
			case "Predefinida": 
				$this->aListadoReglas = $this->aSquid->ReglasPredefinidas;
				break;
			case "Cache":
				foreach ($this->aSquid->ReglasSquid as $lReglaSquid){
					if ($lReglaSquid->TipoAcceso->Nombre == "no_cache") {
						$this->aListadoReglas[] = $lReglaSquid;
					}
				}
			case "Personalizada": 
				foreach ($this->aSquid->ReglasSquid as $lReglaSquid){
					if ($lReglaSquid->TipoAcceso->Nombre == "http_access") {
						$this->aListadoReglas[] = $lReglaSquid;
					}
				}
				break;
		}
		
		/*
		private $aListadoReglas = array();*/
	}
	
	protected function cargarReferencias( ) {
		try {
			$lDAOTipoACL = new DAOTipoACL();
			$this->aTiposRegla = $lDAOTipoACL->listarTodos();
			
			$lDAOListaControlAcceso = new DAOListaControlAcceso();
			$this->aListasControlAcceso = $lDAOListaControlAcceso->listarNombresRegistrados($this->aSquid->ID);
			
			$lDAOReglaPredefinida = new DAOReglaPredefinida();
			$this->aReglasPredefinidas = $lDAOReglaPredefinida->listarNoSquid($this->aSquid->ID);
			
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
		$this->aSquid = new Squid;
		$this->aListadoReglas = array();
		$this->aReglasPredefinidas = array();
		$this->aListasControlAcceso = array();
		$this->aTiposRegla = array();
	} // end of member function __construct

} // end of ControladorServidor
?>
