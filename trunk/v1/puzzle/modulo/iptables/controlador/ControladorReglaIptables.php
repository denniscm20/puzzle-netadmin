<?php
/**
 * @package /controlador/
 * @class ControladorSubred
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once LIB."validator.php";
require_once DAO.'DAONodo.php';
require_once DAO.'DAOSubred.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Nodo.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'Subred.php';
require_once DAO_IPTABLES.'DAOProtocolo.php';
require_once DAO_IPTABLES.'DAOReglaIptables.php';
require_once DAO_IPTABLES.'DAOReglaPredefinida.php';
require_once DAO_IPTABLES.'DAOCategoria.php';
require_once DAO_IPTABLES.'DAOCadena.php';
require_once DAO_IPTABLES.'DAOPolitica.php';
require_once DAO_IPTABLES.'DAOEstado.php';
require_once DAO_IPTABLES.'DAOReglaPredefinida.php';
require_once DAO_IPTABLES.'DAOIptables.php';
require_once DAO_IPTABLES.'DAOAccion.php';
require_once CLASES_IPTABLES.'Protocolo.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once CLASES_IPTABLES.'Categoria.php';
require_once CLASES_IPTABLES.'Cadena.php';
require_once CLASES_IPTABLES.'Politica.php';
require_once CLASES_IPTABLES.'Estado.php';
require_once CLASES_IPTABLES.'Table.php';
require_once CLASES_IPTABLES.'ReglaPredefinida.php';

/**
 * @class ControladorIptables
 * Controlador de la pantalla VistaReglasIptables
 */
class ControladorReglaIptables extends Controlador {

	private $aIptables = null;
	private $aReglaIptables = null;
	private $aTable = null;
	private $aPoliticas = array();
	private $aCategorias = array();
	private $aCategoria = null;
	private $aReglasPredefinidas = array();
	private $aAcciones = array();
	private $aInterfaces = array();
	
	private $aSubredesInput = array();
	private $aSubredInput = null;
	private $aNodosInput = array();
	private $aSubredesOutput = array();
	private $aSubredOutput = null;
	private $aNodosOutput = array();
	private $aEstados = array();
	private $aProtocolos = array();	
	
	private $aReglasPredefinidasShow = array();
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorReglaIptables();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "aplicarPoliticas":
			case "agregarReglaPredefinida":
			case "eliminarReglaPredefinida":
			case "agregarRegla":
			case "eliminarRegla":
			case "salir":
				$this->{$pEvento}();
				break;
		}
		$this->cargarObjeto();
		$this->cargarReferencias();
	}
	
	public function getIptables() {
		return $this->aIptables;
	}
	
	public function getTable() {
		return $this->aTable;
	}
	
	public function getNodosInput() {
		return $this->aNodosInput;
	}
	
	public function getNodosOutput() {
		return $this->aNodosOutput;
	}
	
	public function getProtocolos() {
		return $this->aProtocolos;
	}
	
	public function getSubredesInput() {
		return $this->aSubredesInput;
	}
	
	public function getSubredInput() {
		return $this->aSubredInput;
	}
	
	public function getSubredesOutput() {
		return $this->aSubredesOutput;
	}
	
	public function getSubredOutput() {
		return $this->aSubredOutput;
	}
	
	public function getInterfaces() {
		return $this->aInterfaces;
	}
	
	public function getReglasPredefinidas() {
		return $this->aReglasPredefinidas;
	}
	
	public function getPoliticas() {
		return $this->aPoliticas;
	}
	
	public function getCategorias() {
		return $this->aCategorias;
	}
	
	public function getCategoria() {
		return $this->aCategoria;
	}
	
	public function getEstados() {
		return $this->aEstados;
	}
	
	public function getAcciones() {
		return $this->aAcciones;
	}
	
	public function getReglasPredefinidasShow() {
		return $this->aReglasPredefinidasShow;
	}
	
	public function getReglaIptables() {
		return $this->aReglaIptables;
	}
	
	protected function agregarReglaPredefinida() {
		try {
			$lReglaPredefinidaID = $_POST["cmbReglaPredefinida"];
			$lAccionID = $_POST["cmbAccion"];
			$lIptablesID = $_POST["Iptables"];
			
			if (($lReglaPredefinidaID > 0) and ($lAccionID > 0) and ($lIptablesID > 0)) {
				$lReglaPredefinida = new ReglaPredefinidaIptables();
				$lReglaPredefinida->ID = $lReglaPredefinidaID;
				$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables($lReglaPredefinida);
				$lDAOReglaPredefinida->agregarReglaPredefinida ($lIptablesID, $lAccionID);
				
				require_once DAO_SQUID."DAOReglaPredefinida.php";
				$lDAOReglaPredefinida = new DAOReglaPredefinida();
				$lDAOReglaPredefinida->agregarRegla($lReglaPredefinida->ID);
			} else {
				throw new Exception("No se ha seleccionado una opción válida");
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarReglaPredefinida() {
		try {
			$lReglaID = $_POST["ReglaID"];
			$lIptablesID = $_POST["Iptables"];
			
			$lReglaPredefinida = new ReglaPredefinidaIptables();
			$lReglaPredefinida->ID = $lReglaID;
			$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables($lReglaPredefinida);
			$lDAOReglaPredefinida->eliminarPorReglaPredefinidaIptables($lIptablesID);
			
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function agregarRegla() {
		try {
			if (trim($_POST["txtIPOrigen"]) != "" &&  !Validator::validarIp4(trim($_POST["txtIPOrigen"]))) {
				throw new Exception ("El IP de ORIGEN no es válido.");
			}
			if (trim($_POST["txtIPDestino"]) != "" &&  !Validator::validarIp4(trim($_POST["txtIPDestino"]))) {
				throw new Exception ("El IP de DESTINO no es válido.");
			}
			if (trim($_POST["txtPuertoOrigenInicial"]) != "" &&  !is_int((int)trim($_POST["txtPuertoOrigenInicial"]))) {
				throw new Exception ("El Puerto de Origen no es válido.");
			}
			if (trim($_POST["txtPuertoDestinoInicial"]) != "" &&  !is_int((int)trim($_POST["txtPuertoDestinoInicial"]))) {
				throw new Exception ("El Puerto de Destino no es válido.");
			}
			if ($_POST["cmbAccion"] == 0) {
				throw new Exception ("No se ha seleccionado una acción a Ejecutar.");
			}
			
			$this->cargarObjeto();
			
			$lCadenaNombre = "";
			if ($this->aReglaIptables->InterfazDestino->Nombre == "lo") {
				$lCadenaNombre = "INPUT";
			} else if ($this->aReglaIptables->InterfazOrigen->Nombre == "lo") {
				$lCadenaNombre = "OUTPUT";
			} else if (($this->aReglaIptables->InterfazOrigen->Nombre != "lo") && ($this->aReglaIptables->InterfazDestino->Nombre != "lo")) {
				$lCadenaNombre = "FORWARD";
			}
			
			$lCadena = new Cadena();
			$lCadena->Nombre = $lCadenaNombre;
			$lDAOCadena = new DAOCadena($lCadena);
			$lCadena = $lDAOCadena->buscarPorNombreTable($this->aTable->ID);
			$lDAOReglaIptables = new DAOReglaIptables($this->aReglaIptables);
			$lDAOReglaIptables->agregar($_POST["Iptables"],$lCadena->ID);
			
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarRegla() {
		try {
			$lReglaID = $_POST["ReglaID"];
			
			$lReglaIptables = new ReglaIptables();
			$lReglaIptables->ID = $lReglaID;
			$lDAOReglaIptables = new DAOReglaIptables($lReglaIptables);
			$lDAOReglaIptables->eliminar();
			
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function salir() {
		header("Location: /index.php?Pagina=PanelControl");
	}
	
	protected function aplicarPoliticas() {
		try {
			$this->aIptables->ID = $_POST["Iptables"];
			$lDAOIptables = new DAOIptables($this->aIptables);
			$this->aIptables = $lDAOIptables->buscarID();
		
			$this->aTable->Nombre = "Filter";
			$lDAOTable = new DAOTable($this->aTable);
			$this->aTable = $lDAOTable->listarPorNombre();
			
			$lDAOCadena = new DAOCadena();
			$this->aCadenas = $lDAOCadena->listarPorTable($this->aTable->ID);
			
			$lCount = count($this->aCadenas);
			$lPoliticasID  = array();
			for ($i = 0; $i < $lCount; $i++) {
				$lCadena = $this->aCadenas[$i];
				$lPoliticaID = $_POST["cmbCadena".$lCadena->ID];
				if ($lPoliticaID > 0) {
					$lPoliticasID[] = $lPoliticaID;
				} else {
					throw new Exception("No se han definido todas las políticas");
				}
			}
			
			for ($i = 0; $i < $lCount; $i++) {
				$lCadena = new Cadena();
				$lCadena->ID = $this->aCadenas[$i]->ID;
				$lDAOCadena = new DAOCadena($lCadena);
				$lPoliticaID = $_POST["cmbCadena".$lCadena->ID];
				$lDAOCadena->actualizarPoliticas($this->aIptables->ID, $lPoliticasID[$i]);
			}
			
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function cargarObjeto() {
		if (isset($_POST["Iptables"]) and ($_POST["Iptables"] > 0)) {
			$this->aIptables->ID = $_POST["Iptables"];
			$lDAOIptables = new DAOIptables($this->aIptables);
			$this->aIptables = $lDAOIptables->buscarID();
		} else {
			try {
				$lDAOIptables = new DAOIptables();
				$this->aIptables = $lDAOIptables->buscarActivo();
			} catch (Exception $e) {
				$_SESSION["error"] = $e->getMessage();
			}
		}
		
		$lRegla = isset($_GET["Regla"])?$_GET["Regla"]:"Politica";
		switch($lRegla) {
			case "Politica":
			case "Predefinida":
				break;
			case "Personalizada":
				try {
					$this->aReglaIptables->InterfazOrigen->ID = isset($_POST["cmbInterfazInput"])?$_POST["cmbInterfazInput"]:0;
					$lDAOInterfaz = new DAOInterfaz($this->aReglaIptables->InterfazOrigen);
					$this->aReglaIptables->InterfazOrigen = $lDAOInterfaz->buscarID();
					
					$lSubredInput = new Subred();
					$lSubredInput->ID = isset($_POST["cmbSubredInput"])?$_POST["cmbSubredInput"]:0;
					$lDAOSubred = new DAOSubred($lSubredInput);
					$lSubredInput = $lDAOSubred->buscarID();
					
					$this->aReglaIptables->PuertoOrigenInicial = isset($_POST["txtPuertoOrigenInicial"])?$_POST["txtPuertoOrigenInicial"]:"";
					$this->aReglaIptables->PuertoOrigenFinal = isset($_POST["txtPuertoOrigenFinal"])?$_POST["txtPuertoOrigenFinal"]:"";
					if (isset($_POST["txtIPOrigen"])) {
						$this->aReglaIptables->IPOrigen = (trim($_POST["txtIPOrigen"]) != "") ? $_POST["txtIPOrigen"] : $lSubredInput->IP;
						$this->aReglaIptables->MascaraOrigen = (trim($_POST["txtIPOrigen"]) != "") ? $_POST["txtMascaraOrigen"] : $lSubredInput->MascaraCorta;
					} else {
						$this->aReglaIptables->IPOrigen = "";
						$this->aReglaIptables->MascaraOrigen = "";
					}
					
					$this->aReglaIptables->InterfazDestino->ID = isset($_POST["cmbInterfazOutput"])?$_POST["cmbInterfazOutput"]:0;
					$lDAOInterfaz = new DAOInterfaz($this->aReglaIptables->InterfazDestino);
					$this->aReglaIptables->InterfazDestino = $lDAOInterfaz->buscarID();
					
					$lSubredOutput = new Subred();
					$lSubredOutput->ID = isset($_POST["cmbSubredOutput"])?$_POST["cmbSubredOutput"]:0;
					$lDAOSubred = new DAOSubred($lSubredOutput);
					$lSubredOutput = $lDAOSubred->buscarID();
					
					$this->aReglaIptables->PuertoDestinoInicial = isset($_POST["txtPuertoDestinoInicial"])?$_POST["txtPuertoDestinoInicial"]:"";
					$this->aReglaIptables->PuertoDestinoFinal = isset($_POST["txtPuertoDestinoFinal"])?$_POST["txtPuertoDestinoFinal"]:"";
					if (isset($_POST["txtIPDestino"])) {
						$this->aReglaIptables->IPDestino = (trim($_POST["txtIPDestino"]) != "") ? $_POST["txtIPDestino"] : $lSubredOutput->IP;
						$this->aReglaIptables->MascaraDestino = (trim($_POST["txtIPDestino"]) != "") ? $_POST["txtMascaraDestino"] : $lSubredOutput->MascaraCorta;
					} else {
						$this->aReglaIptables->IPDestino = "";
						$this->aReglaIptables->MascaraDestino = "";
					}
	
					$this->aReglaIptables->Protocolo->ID = isset($_POST["cmbProtocolo"])?$_POST["cmbProtocolo"]:0;
					$lDAOProtocolo = new DAOProtocolo($this->aReglaIptables->Protocolo);
					$this->aReglaIptables->Protocolo = $lDAOProtocolo->buscarID();
	
					$this->aReglaIptables->Accion->ID = isset($_POST["cmbAccion"])?$_POST["cmbAccion"]:0;
					$lDAOAccion = new DAOAccionIptables($this->aReglaIptables->Accion);
					$this->aReglaIptables->Accion = $lDAOAccion->buscarID();
	
					$this->aReglaIptables->Estado->ID = isset($_POST["cmbEstado"])?$_POST["cmbEstado"]:0;
					$lDAOEstado = new DAOEstado($this->aReglaIptables->Estado);
					$this->aReglaIptables->Estado = $lDAOEstado->buscarID();
	
					$this->aReglaIptables->MAC = isset($_POST["txtMAC"])?$_POST["txtMAC"]:"";
				} catch (Exception $e) {
					throw $e;
				}
				break;
		}
		
		foreach ($this->aIptables->Tablas as $lTabla) {
			if ($lTabla->Nombre == "Filter") {
				$this->aTable = $lTabla;
				break;
			}
		}
	}
	
	protected function cargarReferencias() {
		$lRegla = isset($_GET["Regla"])?$_GET["Regla"]:"Politica";
		switch($lRegla) {
			case "Politica":
				$lDAOPolitica = new DAOPolitica();
				$this->aPoliticas = $lDAOPolitica->listarTodos();
				
				break;
				
			case "Predefinida":
				$this->aCategoria = new Categoria();
				$this->aCategoria->ID = isset($_POST["cmbCategoria"])?$_POST["cmbCategoria"]:0;
				$lDAOCategoria = new DAOCategoria($this->aCategoria);
				$this->aCategorias = $lDAOCategoria->listarTodos();
				$this->aCategoria = $lDAOCategoria->buscarID();
				
				$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables();
				$this->aReglasPredefinidas = $lDAOReglaPredefinida->listarPorCategoria($this->aCategoria->ID);
				
				$lDAOAccion = new DAOAccionIptables();
				$this->aAcciones = $lDAOAccion->listarPorTable($this->aTable->ID);
				
				$this->cargarReglasPredefinidasShow();
				
				break;
				
			case "Personalizada":
				$lDAOAccion = new DAOAccionIptables();
				$this->aAcciones = $lDAOAccion->listarPorTable($this->aTable->ID);
				
				$lDAOEstado = new DAOEstado();
				$this->aEstados = $lDAOEstado->listarTodos();
				
				$lDAOInterfaz = new DAOInterfaz();
				$this->aInterfaces = $lDAOInterfaz->listarPorServidor(1);
				
				$this->aSubredesInput = $this->aReglaIptables->InterfazOrigen->Subredes;
				$this->aSubredesOutput = $this->aReglaIptables->InterfazDestino->Subredes;
				
				foreach($this->aSubredesInput as $lSubred) {
					if ($lSubred->ID == $_POST["cmbSubredInput"]) {
						$this->aSubredInput = $lSubred;
					}
				}
		
				foreach($this->aSubredesOutput as $lSubred) {
					if ($lSubred->ID == $_POST["cmbSubredOutput"]) {
						$this->aSubredOutput = $lSubred;
					}
				}
				
				$this->aNodosInput = $this->aSubredInput->Nodos;
				$this->aNodosOutput = $this->aSubredOutput->Nodos;
		
				$lDAOProtocolo = new DAOProtocolo();
				$this->aProtocolos = $lDAOProtocolo->listarTodos();
		
				break;
		}
	}
	
	protected function cargarReglasPredefinidasShow() {
		try {
			$lDAOCategoria = new DAOCategoria();
			$this->aReglasPredefinidasShow = $lDAOCategoria->listarPorIptables($this->aIptables->ID);
			
			$lCount = count ($this->aReglasPredefinidasShow);
			for ($i = 0; $i < $lCount; $i++) {
				$lCategoria = $this->aReglasPredefinidasShow[$i];
				$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables();
				$lCategoria->ReglasPredefinidas = $lDAOReglaPredefinida->listarPorCategoriaIptables( $lCategoria->ID, $this->aIptables->ID);
				$this->aReglasPredefinidasShow[$i] = $lCategoria;
			}
			
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
		$this->aIptables = new Iptables();
		$this->aReglaIptables = new ReglaIptables();
		$this->aTable = new Table();
		$this->aPoliticas = array();
		$this->aProtocolos = array();
		$this->aCategorias = array();
		$this->aEstados = array();
		$this->aInterfaces = array();
		
		$this->aSubredesInput = array();
		$this->aSubredInput = new Subred();
		$this->aNodosInput = array();
		$this->aSubredesOutput = array();
		$this->aSubredOutput = new Subred();
		$this->aNodosOutput = array();
		
		$this->aReglasPredefinidas = array();
	} // end of member function __construct

} // end of ControladorServidor
?>
