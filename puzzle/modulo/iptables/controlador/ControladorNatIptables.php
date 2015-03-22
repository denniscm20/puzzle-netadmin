<?php
/**
 * @package /controlador/
 * @class ControladorSubred
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once DAO.'DAONodo.php';
require_once DAO.'DAOSubred.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Nodo.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'Subred.php';
require_once DAO_IPTABLES.'DAOReglaIptables.php';
require_once DAO_IPTABLES.'DAOCadena.php';
require_once DAO_IPTABLES.'DAOPolitica.php';
require_once DAO_IPTABLES.'DAOEstado.php';
require_once DAO_IPTABLES.'DAOReglaPredefinida.php';
require_once DAO_IPTABLES.'DAOTable.php';
require_once DAO_IPTABLES.'DAOIptables.php';
require_once DAO_IPTABLES.'DAOAccion.php';
require_once DAO_IPTABLES.'DAOProtocolo.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once CLASES_IPTABLES.'Cadena.php';
require_once CLASES_IPTABLES.'Politica.php';
require_once CLASES_IPTABLES.'Table.php';

/**
 * @class ControladorIptables
 * Controlador de la pantalla VistaNatIptables
 */
class ControladorNatIptables extends Controlador {

	private $aIptables = null;
	private $aTablaNat = null;
	private $aReglaNat = null;
	private $aPoliticas = array();
	private $aAcciones = array();
	private $aInterfaces = array();
	private $aSubredEntrada = array();
	private $aSubredSalida = array();
	private $aNodoSalida = array();
	private $aProtocolos = array();
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorNatIptables();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "aplicarPoliticas":
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
	
	public function getTablaNat() {
		return $this->aTablaNat;
	}
	
	public function getReglaNat() {
		return $this->aReglaNat;
	}
	
	public function getPoliticas() {
		return $this->aPoliticas;
	}
	
	public function getAcciones() {
		return $this->aAcciones;
	}
	
	public function getInterfaces() {
		return $this->aInterfaces;
	}
	
	public function getSubredEntrada() {
		return $this->aSubredEntrada;
	}
	
	public function getNodoSalida() {
		return $this->aNodoSalida;
	}
	
	public function getSubredSalida() {
		return $this->aSubredSalida;
	}
	
	public function getProtocolos() {
		return $this->aProtocolos;
	}
	
	protected function agregarRegla() {
		try {
			/* MASQUERADING: In some instances you have a group of computers that you want to share one public IP address (dynamic external)
			 * SNAT: Let's say you have a range of public static IP addresses from 1.2.3.4 to 1.2.3.10 (yes, we know those aren't legal) and you want to enable the router to change the source addresses to one of those addresses.
			 * DNAT: This will rewrite packets coming in through the first Ethernet interface to one of the internal machines with an IP address of 10.0.0.4 to 10.0.0.14.
			 * REDIRECT: Puerto local a otro puerto local
			 */
			if (!isset($_POST["rdbTipo"])) {
				throw new Exception("Debe de seleccionar un tipo de regla");
			}
			
			$this->cargarObjeto();
			$lNombreCadena = "";
			
			switch ($this->aReglaNat->Accion->Nombre) {
				case "MASQUERADE":
				case "SNAT":
					$lNombreCadena = "POSTROUTING";
					break;
				case "DNAT":
				case "REDIRECT":
					$lNombreCadena = "PREROUTING";
					break;
				default: 
					throw new Exception("Accion no definida");
					break;
			}
			
			$lCadena = new Cadena();
			$lCadena->Nombre = $lNombreCadena;
			$lDAOCadena = new DAOCadena($lCadena);
			$lCadena = $lDAOCadena->buscarPorNombreTable( $this->aTablaNat->ID );
			
			$lDAOReglaIptables = new DAOReglaIptables($this->aReglaNat);
			$lDAOReglaIptables->agregar($this->aIptables->ID, $lCadena->ID);
			
			header ("Location: index.php?Pagina=NatIptables&Modulo=Iptables&Regla=Personalizada");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarRegla() {
		try {
			$lReglaID = $_POST["ReglaID"];
			$this->aReglaNat->ID = $lReglaID;
			$lDAOReglaIptables = new DAOReglaIptables($this->aReglaNat);
			$lDAOReglaIptables->eliminar();
			
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function salir() {
		header("Location: index.php?Pagina=PanelControl");
	}
	
	protected function aplicarPoliticas() {
		try {
			$this->aIptables->ID = $_POST["Iptables"];
			$lDAOIptables = new DAOIptables($this->aIptables);
			$this->aIptables = $lDAOIptables->buscarID();
		
			$this->aTablaNat->Nombre = "NAT";
			$lDAOTable = new DAOTable($this->aTablaNat);
			$this->aTablaNat = $lDAOTable->listarPorNombre();
			
			$lPoliticasID  = array();
			foreach ($this->aTablaNat->Cadenas as $lCadena) {
				$lPoliticaID = $_POST["cmbCadena".$lCadena->ID];
				if ($lPoliticaID > 0) {
					$lPoliticasID[] = $lPoliticaID;
				} else {
					throw new Exception("No se han definido todas las políticas");
				}
			}
			
			$lCounter = count($this->aTablaNat->Cadenas);
			for ($i = 0; $i < $lCounter; $i++) {
				$lCadena = $this->aTablaNat->Cadenas[$i];
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
		
		foreach ($this->aIptables->Tablas as $lTabla) {
			if ($lTabla->Nombre == "NAT") {
				$this->aTablaNat = $lTabla;
				break;
			}
		}
		
		$lRegla = isset($_GET["Regla"])?$_GET["Regla"]:"Politica";
		switch($lRegla) {
			case "Politica":
				break;
			case "Personalizada":
				$lDAOInterfaz = new DAOInterfaz();
				$this->aInterfaces = $lDAOInterfaz->listarPorServidor(1);
				
				$this->aReglaNat = new ReglaIptables();
				
				$lAccion = new AccionIptables();
				$lTipo = isset($_POST["rdbTipo"])?$_POST["rdbTipo"]:0;
				$lAccion->ID = is_array($lTipo)?$lTipo[0]:0;
				$lDAOAccion = new DAOAccionIptables($lAccion);
				$lAccion = $lDAOAccion->buscarID();
				$this->aReglaNat->Accion = $lAccion;
				
				$lProtocolo = new Protocolo();
				$lProtocolo->ID = isset($_POST["cmbProtocolo"])?$_POST["cmbProtocolo"]:0;
				$lDAOProtocolo = new DAOProtocolo($lProtocolo);
				$lProtocolo = $lDAOProtocolo->buscarID();
				$this->aReglaNat->Protocolo = $lProtocolo;
				
				if (isset($_POST["cmbInterfazEntrada"]) && isset($_POST["cmbInterfazSalida"])) {
					foreach($this->aInterfaces as $lInterfaz) {
						if ($lInterfaz->ID == $_POST["cmbInterfazEntrada"]) {
							$this->aReglaNat->InterfazOrigen = $lInterfaz;
						}
						if ($lInterfaz->ID == $_POST["cmbInterfazSalida"]) {
							$this->aReglaNat->InterfazDestino = $lInterfaz;
						}
					}
				}
				
				$this->aReglaNat->PuertoOrigenInicial = isset($_POST["txtPuertoDestinoInicial"])?$_POST["txtPuertoDestinoInicial"]:"";
				$this->aReglaNat->PuertoOrigenFinal = isset($_POST["txtPuertoDestinoFinal"])?$_POST["txtPuertoDestinoFinal"]:"";
				$this->aReglaNat->PuertoDestinoInicial = isset($_POST["txtPuertoNuevoInicial"])?$_POST["txtPuertoNuevoInicial"]:"";
				$this->aReglaNat->PuertoDestinoFinal = isset($_POST["txtPuertoNuevoFinal"])?$_POST["txtPuertoNuevoFinal"]:"";
				
				$this->aReglaNat->IPOrigen = isset($_POST["txtIPEntrada"])?$_POST["txtIPEntrada"]:"";
				$this->aReglaNat->IPDestino = isset($_POST["txtIPNueva"])?$_POST["txtIPNueva"]:"";
				
				break;
		}
	}
	
	protected function cargarReferencias() {
		$lRegla = isset($_GET["Regla"])?$_GET["Regla"]:"Politica";
		switch($lRegla) {
			case "Politica":
				$lDAOPolitica = new DAOPolitica();
				$this->aPoliticas = $lDAOPolitica->listarTodos();
				
				break;
			case "Personalizada":
				$lDAOAccion = new DAOAccionIptables();
				$this->aAcciones = $lDAOAccion->listarPorTable($this->aTablaNat->ID);
				
				$lDAOProtocolo = new DAOProtocolo();
				$this->aProtocolos = $lDAOProtocolo->listarTodos();
				foreach($this->aReglaNat->InterfazOrigen->Subredes as $lSubred) {
					if ($lSubred->ID == $_POST["cmbSubredEntrada"]) {
						$this->aSubredEntrada = $lSubred;
						break;
					}
				}
				
				foreach($this->aReglaNat->InterfazDestino->Subredes as $lSubred) {
					if ($lSubred->ID == $_POST["cmbSubredSalida"]) {
						$this->aSubredSalida = $lSubred;
						break;
					}
				}
				
				break;
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
		$this->aTablaNat = new Table();
		$this->aReglaNat = new ReglaIptables();
		$this->aPoliticas = array();
		$this->aAcciones = array();
		$this->aInterfaces = array();
		$this->aSubredEntrada = new Subred();
		$this->aSubredSalida = new Subred();
		$this->aNodoSalida = array();
		$this->aProtocolos = array();
	} // end of member function __construct

} // end of ControladorServidor
?>
