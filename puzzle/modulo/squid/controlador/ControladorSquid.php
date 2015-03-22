<?php
/**
 * @package /controlador/
 * @class ControladorSquid
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once CLASES_SQUID.'Squid.php';
require_once CLASES_SQUID.'PuertoSquid.php';
require_once CLASES_SQUID.'HistoricoSquid.php';
require_once DAO_SQUID.'DAOSquid.php';
require_once DAO_SQUID.'DAOPuertoSquid.php';
require_once DAO_SQUID.'DAOHistoricoSquid.php';
require_once CLASES.'Interfaz.php';
require_once DAO.'DAOInterfaz.php';
require_once LIB.'File.php';

/**
 * @class ControladorSquid
 * Controlador de la pantalla VistaSquid
 */
class ControladorSquid extends Controlador {

	private $aSquid = null;
	private $aPuertosSquid = null;
	private $aInterfaces = array();
	private $aPagina = 0;
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorSquid();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		$this->cargarObjeto();
		switch ($pEvento) {
			case "guardar":
			case "cancelar":
			case "siguiente":
			case "anterior":
			case "agregarPuerto":
			case "eliminarPuerto":
			case "importar":
				$this->{$pEvento}();
				break;
		}
		$this->cargarReferencias();
	}
	
	public function getSquid() {
		return $this->aSquid;
	}
	
	public function getPuertosSquid() {
		return $this->aPuertosSquid;
	}
	
	public function getInterfaces() {
		return $this->aInterfaces;
	}
	
	public function getPagina() {
		return $this->aPagina;
	}
	
	protected function cargarObjeto() {
		if (isset($_SESSION["squid"])) {
			$this->aSquid = unserialize($_SESSION["squid"]);
		}
	}
	
	protected function cancelar( ) {
		if (isset($_SESSION["squid"])) {
			unset($_SESSION["squid"]);
		}
		header("Location: /index.php?Pagina=PanelControl");
	}

	/**
	 * Permite eliminar una dirección IP.
	 *
	 * @return bool
	 * @access public
	*/
	protected function guardar( ) {
		try {
			$this->aTotalPuertos = $_POST["TotalPuertos"];
			$this->actualizarSquid();
			$lDAOSquid = new DAOSquid($this->aSquid);
			$lDAOSquid->agregar();
			
			$lSquid = $lDAOSquid->buscarMaxID();
			
			$lPuertos = $this->aSquid->HttpPort;
			foreach ($lPuertos as $lPuertoSquid) {
				$lDAOPuertoSquid = new DAOPuertoSquid($lPuertoSquid);
				$lDAOPuertoSquid->agregar($lSquid->ID);
			}
			
			$lHistoricoSquid = new HistoricoSquid();
			$lHistoricoSquid->Squid = $lSquid;
			$lDAOHistoricoSquid = new DAOHistoricoSquid($lHistoricoSquid);
			$lDAOHistoricoSquid->agregar();
			
			if ($this->aSquid->Transparent) {
				
				$lPuertos = array();
				foreach ($this->aSquid->HttpPort as $lPuertoSquid) {
					$lPuertos[] = $lPuertoSquid->Puerto;
				}
				require_once(DAO_IPTABLES.'DAOReglaIptables.php');
				$lDAOReglaIptables = new DAOReglaIptables(null);
				$lDAOReglaIptables->habilitarProxyTransparente($lPuertos);
			}
			
			if (isset($_SESSION["squid"])) {
				unset($_SESSION["squid"]);
			}
			
			header("Location: /index.php?Pagina=PanelControl");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function eliminar	
	
	protected function siguiente() {
		try {
			$this->aPagina = $_POST["Pagina"];
			$this->actualizarSquid();
			$this->aPagina ++;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
		
	/**
	 * Permite buscar la información de un servidor de acuerdo a su ID.
	 *
	 * @return 
	 * @access public
	 */
	protected function anterior( ) {
		try {
			$this->aPagina = $_POST["Pagina"];
			$this->actualizarSquid();
			$this->aPagina --;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function buscarID
	
	protected function agregarPuerto() {
		try {
			$this->aPagina = $_POST["Pagina"];
			
			$lPuertoSquid = new PuertoSquid();
			$lPuertoSquid->Puerto = $_POST["txtPuerto"];
			$lPuertoSquid->Descripcion = $_POST["txtDescripcion"];
			$lPuertoSquid->Interfaz = new Interfaz();
			$lPuertoSquid->Interfaz->ID = $_POST["cmbInterfaz"];
			
			$lDAOInterfaz = new DAOInterfaz($lPuertoSquid->Interfaz);
			$lPuertoSquid->Interfaz = $lDAOInterfaz->buscarID();
			$lHttpPort = $this->aSquid->HttpPort;
			$lHttpPort[] = $lPuertoSquid;
			$this->aSquid->HttpPort = $lHttpPort;
			$_SESSION["squid"] = serialize($this->aSquid);
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarPuerto() {
		try {
			$this->aPagina = $_POST["Pagina"];
			
			$lPuerto = $_POST["Puerto"];
			$lTemp = array();
			for ($i = 0; $i < $this->aTotalPuertos; $i++) {
				if ($i != $lPuerto) {
					$lTemp[] = $this->aSquid->HttpPort[$i];
				}
			}
			$this->aSquid->HttpPort = $lTemp;
			$_SESSION["squid"] = serialize($this->aSquid);
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function actualizarSquid() {
		switch($this->aPagina) {
			case 1: break;
			case 2: $this->aSquid->CacheDir = $_POST["txtCacheDir"];
					$this->aSquid->CacheMaxSize = $_POST["txtCacheMaxSize"];
					$this->aSquid->DirNumber1 = $_POST["txtDirNumber1"];
					$this->aSquid->DirNumber2 = $_POST["txtDirNumber2"];
					break;
			case 3: $this->aSquid->CacheLog = $_POST["txtCacheLog"];
					$this->aSquid->StoreLog = $_POST["txtStoreLog"];
					$this->aSquid->AccessLog = $_POST["txtAccessLog"];
					$this->aSquid->LogFqdn = isset($_POST["chkLogFqdn"]);
					break;
			case 4: $this->aSquid->Transparent = isset($_POST["chkTransparente"]);
					break;
		}
		$_SESSION["squid"] = serialize($this->aSquid);
	}
	
	protected function importar() {
		$lDirectorio = TMP;
		$lArchivo = $lDirectorio.basename($_FILES['txtFile']['name']);
		if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $lArchivo)) {
			//Establecer como temporal
			$lXML = new SimpleXMLElement($lArchivo, NULL, TRUE);
			
			$this->aSquid = new Squid();
			
			$lSquidXML = $lXML->Squid[0];
			$this->aSquid = new Squid();
			$this->aSquid->IcpPort = $lSquidXML->IcpPort;
			$this->aSquid->VisibleHostname = $lSquidXML->VisibleHostname;
			$this->aSquid->CacheDir = $lSquidXML->CacheDir;
			$this->aSquid->CacheMaxSize = $lSquidXML->CacheMaxSize;
			$this->aSquid->DirNumber1 = $lSquidXML->DirNumber1;
			$this->aSquid->DirNumber2 = $lSquidXML->DirNumber2;
			$this->aSquid->CacheLog = $lSquidXML->CacheLog;
			$this->aSquid->StoreLog = $lSquidXML->StoreLog;
			$this->aSquid->AccessLog = $lSquidXML->AccessLog;
			$this->aSquid->LogFqdn = ($lSquidXML->LogFqdn != 0);
			$this->aSquid->DnsNameservers = $lSquidXML->DnsNameservers;
			$this->aSquid->Transparent = ($lSquidXML->Transparent != 0);
			
			$lHttpPort = array();
			foreach ($lSquidXML->HttpPorts->PuertoSquid as $lPuertoSquidXML) {
				$lPuertoSquid = new PuertoSquid();
				$lPuertoSquid->Puerto = $lPuertoSquidXML->Puerto;
				$lPuertoSquid->Descripcion = $lPuertoSquidXML->Descripcion;
				$lPuertoSquid->Interfaz->ID = $lPuertoSquidXML->Interfaz;
				$lHttpPort[] = $lPuertoSquid;
			}
			$this->aSquid->HttpPort = $lHttpPort;
			
			$lReglasSquid = array();
			if (isset($lSquidXML->ReglasSquid->ReglaSquid)) {
				foreach ($lSquidXML->ReglasSquid->ReglaSquid as $lReglaSquidXML) {
					$lReglaSquid = new ReglaSquid();
					$lReglaSquid->Accion->ID = $lReglaSquidXML->Accion;
					$lReglaSquid->TipoAcceso->ID = $lReglaSquidXML->TipoAcceso;
					$lReglaSquid->ListaControlAcceso->Nombre = $lReglaSquidXML->ListaControlAcceso->Nombre;
					$lReglaSquid->ListaControlAcceso->TipoACL->ID = $lReglaSquidXML->ListaControlAcceso->TipoACL;
					
					foreach($lReglaSquidXML->ListaControlAcceso->Valores->Valor as $lValorXML) {
						$lValor = new Valor();
						$lValor->Nombre = $lValorXML->Nombre;
						$lReglaSquid->ListaControlAcceso->Valores[] = $lValor;
					}
					$lReglasSquid[] = $lReglaSquid;
				}
			}
			$this->aSquid->ReglasSquid = $lReglasSquid;
			
			$lReglasPredefinidas = array();
			if (isset($lSquidXML->ReglasPredefinidas->ReglaPredefinida)) {
				foreach ($lSquidXML->ReglasPredefinidas->ReglaPredefinida as $lReglaPredefinidaXML) {
					$lReglaPredefinida = new ReglaPredefinida();
					$lReglaPredefinida->ID = $lReglaPredefinidaXML;
					$lReglasPredefinidas[] = $lReglaPredefinida;
				}
			}
			$this->aSquid->ReglasPredefinidas = $lReglasPredefinidas;
			
			/* Agregando a la BD */
			$lDAOSquid = new DAOSquid($this->aSquid);
			$lDAOSquid->agregar();
			
			$lSquid = $lDAOSquid->buscarMaxID();
			
			$lHistorico = new HistoricoSquid();
			$lHistorico->Squid = $lSquid;
			$lHistorico->FechaCreacion = date("Ymd");
			$lHistorico->HoraCreacion = date("H:i");
			$lHistorico->Descripcion = "Archivo importado el ".date("d-m-Y");
			
			$lDAOHistorico = new DAOHistoricoSquid($lHistorico);
			$lDAOHistorico->agregar();
			
			foreach ($this->aSquid->HttpPort as $lPuertoSquid) {
				$lDAOPuertoSquid = new DAOPuertoSquid($lPuertoSquid);
				$lDAOPuertoSquid->agregar($lSquid->ID);
			}
			
			foreach ($this->aSquid->ReglasSquid as $lReglaSquid) {
				$lDAOReglaSquid = new DAOReglaSquid($lReglaSquid);
				$lDAOReglaSquid->agregar($lSquid->ID);
				$lReglaSquidBD = $lDAOReglaSquid->buscarMaxID();
				$lDAOListaControlAcceso = new DAOListaControlAcceso($lReglaSquid->ListaControlAcceso);
				$lDAOListaControlAcceso->agregar($lReglaSquidBD->ID);
				$lListaControlAccesoBD = $lDAOListaControlAcceso->buscarMaxID();
				foreach($lReglaSquid->ListaControlAcceso->Valores as $lValor) {
					$lDAOValor = new DAOValor($lValor);
					$lDAOValor->agregar($lListaControlAccesoBD->ID);
				}
			}
			
			foreach ($this->aSquid->ReglasPredefinidas as $lReglaPredefinida) {
				$lDAOReglaPredefinida = new DAOReglaPredefinida($lReglaPredefinida);
				$lDAOReglaPredefinida->agregar($lSquid->ID);
			}
			
			$_SESSION['info'] = "El archivo ha sido importado exitosamente";
		} else {
			$_SESSION['error'] = "Se ha producido un error al importar el archivo";
		}
		if (isset($_SESSION["snort"])) {
			unset($_SESSION["snort"]);
		}
	}
	
	protected function cargarReferencias( ) {
		try {
			$lDAOInterfaz = new DAOInterfaz();
			$this->aInterfaces = $lDAOInterfaz->listarPorServidor(1);
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
		$this->aPuertosSquid = array();
		$this->aInterfaces = array();
		$this->aPagina = 0;
	} // end of member function __construct

} // end of ControladorServidor
?>
