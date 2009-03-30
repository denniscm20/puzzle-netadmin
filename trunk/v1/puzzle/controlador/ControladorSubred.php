<?php
/**
 * @package /controlador/
 * @class ControladorSubred
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once CLASES.'Subred.php';
require_once CLASES.'Nodo.php';
require_once CLASES.'Interfaz.php';
require_once DAO.'DAOSubred.php';
require_once DAO.'DAOInterfaz.php';
require_once DAO.'DAONodo.php';
require_once LIB.'validator.php';

/**
 * @class ControladorSubred
 * Controlador de la pantalla VistaServidor
 */
class ControladorSubred extends Controlador {

	/*** Attributes: ***/
	
	private $aNodo = null;
	private $aSubred = null;
	private $aInterfaces = array();
	private $aInterfaz = null;


	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorSubred();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia
	
	public function procesar ($pEvento = "") {
		$this->cargarReferencias();
		switch ($pEvento) {
			case "guardar":
			case "agregarNodo":
			case "eliminarNodo":
			case "obtenerHostname":
			case "cancelar":
				$this->{$pEvento}();
				break;
		}
		$this->cargarReferencias();
	}
	
	public function getNodo() {
		return $this->aNodo;
	}
	
	public function getSubred() {
		return $this->aSubred;
	}
	
	public function getInterfaces() {
		return $this->aInterfaces;
	}
	
	public function getInterfaz() {
		return $this->aInterfaz;
	}
	
	protected function cancelar( ) {
		header("Location: index.php?Pagina=AdministrarInterfaz");
	}

	/**
	 * Permite eliminar una dirección IP.
	 *
	 * @return bool
	 * @access public
	*/
	protected function guardar( ) {
		try {
			if ($this->aSubred->Nombre == "") {
				$_SESSION["advertencia"] = "El Nombre de la Subred no puede ser un campo vacío.";
				return false;
			}
			
			if (!Validator::validarIp4($this->aSubred->IP)) {
				$_SESSION["advertencia"] = "La IP registrada no es válida.";
				return false;
			}
			
			if ($this->aSubred->Mascara == "" and $this->aSubred->MascaraCorta == "") {
				$_SESSION["advertencia"] = "Debe de completar el campo Máscara o el campo Máscara Corta.";
				return false;
			}
			
			if ($this->aSubred->Mascara == "" and $this->aSubred->MascaraCorta != "") {
				if (!Validator::validarMascaraCorta($this->aSubred->MascaraCorta)) {
					$_SESSION["advertencia"] = "El valor de la máscara corta se halla fuera de rango.";
					return false;
				}
				$this->aSubred->Mascara = $this->mascaraCortaHaciaMascara($this->aSubred->MascaraCorta);;
			} else if ($this->aSubred->MascaraCorta == "" and $this->aSubred->Mascara != "") {
				if (!Validator::validarMascaraIp4($this->aSubred->Mascara)) {
					$_SESSION["advertencia"] = "La máscara ingresada no es válida.";
					return false;
				}
				$this->aSubred->MascaraCorta = $this->mascaraHaciaMascaraCorta($this->aSubred->Mascara);
			} else {
				if (!Validator::validarMascaraCorta($this->aSubred->MascaraCorta)) {
					$_SESSION["advertencia"] = "El valor de la máscara corta se halla fuera de rango.";
					return false;
				}
				if (!Validator::validarMascaraIp4($this->aSubred->Mascara)) {
					$_SESSION["advertencia"] = "La máscara ingresada no es válida.";
					return false;
				}
				if (!Validator::validarMascara_MascaraCorta($this->aSubred->Mascara, $this->aSubred->MascaraCorta)) {
					$_SESSION["advertencia"] = "No hay correspondencia entre los valores de la Máscara y la Máscara Corta.";
					return false;
				}
			}
			
			$lDAOSubred = new DAOSubred($this->aSubred);
			
			if ($this->aSubred->ID == 0) {
				if ($lDAOSubred->agregar($this->aInterfaz->ID)) {
					$_SESSION["info"] = "Se guardo el registro satisfactoriamente.";
					$this->aSubred = $lDAOSubred->buscarPorNombreIP();
					header("Location: /index.php?Pagina=Subred&Subred=".$this->aSubred->ID);
					return true;
				} else {
					$_SESSION["error"] = "Se produjo un error en la base de datos.";
					return false;
				}
			} else {
				if ($lDAOSubred->modificar($this->aInterfaz->ID)) {
					$_SESSION["info"] = "Se guardo el registro satisfactoriamente.";
					return true;
				} else {
					$_SESSION["error"] = "Se produjo un error en la base de datos.";
					return false;
				}
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function eliminar

	
	private function mascaraHaciaMascaraCorta($pMascara) {
		$lValues = explode(".",$pMascara);
		$lCount = count($lValues);

		if ($lCount != 4) {
			return false;
		}
		
		$lMaskNumber = 0;
		$lZeroValue = false;
		
		for ($i = 0; $i < $lCount; $i++) {
			$lValue = $lValues[$i];
			$lMask = 0x1;
			for ($j = 0; $j < 8; $j++) {
				$lBit = ($lValue >> (7 - $j)) & $lMask;
				if ($lBit) {
					$lMaskNumber++;
				} else {
					$lZeroValue = true;
					break;
				}
			}
			if ($lZeroValue) {
				break;
			}
		}
		
		return $lMaskNumber;
	}
	
	private function mascaraCortaHaciaMascara($pMascaraCorta) {
		$lCounter = 0;
		$lMaxBits = 32;
		$lMascara = "";
		$lSubMascara = "";
		for ($i = 0; $i < $lMaxBits; $i ++ ) {
			if ($pMascaraCorta) {
				$lSubMascara = $lSubMascara . "1";
				$pMascaraCorta--;
			} else {
				$lSubMascara = $lSubMascara . "0";
			}
			$lCounter++;
			if ($lCounter == 8) {
				$lCounter = 0;
				$lSubMascara = base_convert($lSubMascara,2,10);
				$lMascara = $lMascara.$lSubMascara;
				if ($i < ($lMaxBits-1)) {
					$lMascara = $lMascara.".";
				}
				$lSubMascara = "";
			}
		}
		
		return $lMascara;
	}
	
	protected function agregarNodo( ) {
		try {
			$lHostname = trim($_POST["txtHostnameNodo"]);
			$lIP = trim($_POST["txtIPNodo"]);
			$lSubredIP = $this->aSubred->IP;
			
			$lSubredID = $this->aSubred->ID;
			$lMascara = trim ($_POST['txtMascara']);
			
			$this->aNodo = new Nodo($lIP,$lHostname);
			
			if ($lHostname == "") {
				$_SESSION["advertencia"] = "El Nombre del Nodo no puede ser un campo vacío.";
				return false;
			}
			
			if (!Validator::validarIp4($lIP) or !Validator::validarIP_Subred($lIP, $lMascara, $lSubredIP)) {
				$_SESSION["advertencia"] = "La IP registrada no es válida o no pertenece a la subred.";
				return false;
			}
			
			$lDAONodo = new DAONodo ($this->aNodo);
			
			if ($lDAONodo->agregar($lSubredID)) {
				$_SESSION["info"] = "Se guardo el registro satisfactoriamente.";
				$this->aNodo = new Nodo();
				return true;
			} else {
				$_SESSION["error"] = "Se produjo un error en la base de datos.";
				return false;
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function eliminarNodo ( ) {
		try {
			$lNodo = new Nodo();
			$lID = trim($_POST['ID']);
			$lNodo->ID = $lID;

			$lDAONodo = new DAONodo ($lNodo);
			
			if ($lDAONodo->eliminar()) {
				$_SESSION["info"] = "El registro se eliminó satisfactoriamente.";
				return true;
			} else {
				$_SESSION["error"] = "Se produjo un error en la base de datos.";
				return false;
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function obtenerHostname ( ) {
		try {
			$this->aNodo->IP = trim($_POST["txtIPNodo"]);
			$this->aNodo->Hostname = gethostbyaddr($this->aNodo->IP);
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function cargarObjeto() {
		if (isset($_GET["Subred"]) && ($_GET["Subred"] > 0)) {
			$this->aSubred->ID = trim($_GET['Subred']);
			$lDAOSubred = new DAOSubred($this->aSubred);
			$this->aSubred = $lDAOSubred->buscarID();
		} else {
			$this->aSubred->ID = isset($_GET['Subred'])?trim($_GET['Subred']):"";
			$this->aSubred->Nombre = isset($_POST["txtNombre"])?trim($_POST["txtNombre"]):"";
			$this->aSubred->IP = isset($_POST["txtIP"])?trim($_POST["txtIP"]):"";
			$this->aSubred->Mascara = isset($_POST["txtMascara"])?trim($_POST["txtMascara"]):"";
			$this->aSubred->MascaraCorta = isset($_POST["txtMascaraCorta"])?trim($_POST["txtMascaraCorta"]):"";
		}
	}
	
	protected function cargarReferencias() {
		try {
			$lDAOInterfaz = new DAOInterfaz(null);
			$this->aInterfaces = $lDAOInterfaz->listarPorServidor(1);
			
			if (isset($_POST["cmbInterfaz"])) {
				foreach ($this->aInterfaces as $lInterfaz) {
					if ($lInterfaz->ID == trim($_POST["cmbInterfaz"])) {
						$this->aInterfaz = $lInterfaz;
					}
				}
			} else {
				// Load Interface
			}
			
			$this->cargarObjeto();
			if ($this->aSubred->IP == "") {
				$this->aSubred->IP = $this->aInterfaz->IP;
				$this->aSubred->Mascara = $this->aInterfaz->Mascara;
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
		$this->aNodo = new Nodo();
		$this->aSubred = new Subred();
		$this->aInterfaces = array();
		$this->aInterfaz = new Interfaz();
	} // end of member function __construct

} // end of ControladorServidor
?>
