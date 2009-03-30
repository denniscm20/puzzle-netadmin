<?php
/**
 * @package /controlador/
 * @class ControladorSubred
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once DAO_IPTABLES.'DAOIptables.php';
require_once DAO_IPTABLES.'DAOHistoricoIptables.php';
require_once DAO_IPTABLES.'DAOFechaActivacionIptables.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once CLASES_IPTABLES.'HistoricoIptables.php';
require_once CLASES_IPTABLES.'FechaActivacionIptables.php';

require_once LIB.'File.php';

/**
 * @class ControladorIptables
 * Controlador de la pantalla VistaServidor
 */
class ControladorIptables extends Controlador {

	private $aIptables;
	private $aCadenas;
	private $aReglasIptables = array();
	private $aReglasPredefinidas = array();
	
	private $aEsBasico = true;
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorIptables();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "guardar":
			case "importar":
				$this->{$pEvento}();
				break;
		}
	}
	
	public function getIptables() {
		return $this->aIptables;
	}

	/**
	 * Permite eliminar una dirección IP.
	 *
	 * @return bool
	 * @access public
	*/
	protected function guardar( ) {
		try {
			$this->aIptables = new Iptables();
			$this->aIptables->Descripcion = trim($_POST["txtDescripcion"]);
			$lDAOIptables = new DAOIptables($this->aIptables);
			$lDAOIptables->agregar();
			
			$this->aIptables = $lDAOIptables->buscarMaxID();
			
			$lDAOIptables = new DAOIptables($this->aIptables);
			$lDAOIptables->inicializarPoliticas();
			
			$lHistorico = new HistoricoIptables();
			$lHistorico->Iptables = $this->aIptables;
			$lHistorico->FechaCreacion = date("Ymd");
			$lHistorico->HoraCreacion = date("i:s");
			$lHistorico->Descripcion = $this->aIptables->Descripcion;
			
			$lDAOHistorico = new DAOHistoricoIptables($lHistorico);
			$lDAOHistorico->agregar();

			$_SESSION['info'] = "La configuración ha sido creada de forma exitosa.";
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function eliminar	
	
	protected function importar() {
		$lDirectorio = TMP;
		$lArchivo = $lDirectorio.basename($_FILES['txtFile']['name']);
		if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $lArchivo)) {
			//Establecer como temporal
			$lXML = new SimpleXMLElement($lArchivo, NULL, TRUE);
			
			$this->aIptables = new Iptables();
			$this->aIptables->Descripcion = "Archivo importado el ".date("d-m-Y");
			
			$lTablas = array();
			foreach ($lXML->Iptables[0]->Tablas->Table as $lTable) {
				$lTabla = new Table();
				$lTabla->Nombre = $lTable->Nombre;
				$lDAOTable = new DAOTable($lTabla);
				$lTabla = $lDAOTable->listarPorNombre();
				
				$lCadenas = array();
				foreach ($lTable->Cadenas->Cadena as $lCadenaXML) {
					$lCadena = new Cadena($lCadenaXML->Nombre);
					$lDAOCadena = new DAOCadena($lCadena);
					$lCadena = $lDAOCadena->buscarPorNombreTable($lTabla->ID);
					$lCadena->Politica->ID = $lCadenaXML->Politica;
					
					$lReglasIptables = array();
					foreach ($lCadenaXML->ReglasIptables->ReglaIptables as $lReglaIptablesXML) {
						$lReglaIptables = new ReglaIptables();
						$lReglaIptables->PuertoOrigenInicial = $lReglaIptablesXML->PuertoOrigenInicial;
						$lReglaIptables->PuertoOrigenFinal = $lReglaIptablesXML->PuertoOrigenFinal;;
						$lReglaIptables->PuertoDestinoInicial = $lReglaIptablesXML->PuertoDestinoInicial;
						$lReglaIptables->PuertoDestinoFinal = $lReglaIptablesXML->PuertoDestinoFinal;
						$lReglaIptables->IPOrigen = $lReglaIptablesXML->IPOrigen;
						$lReglaIptables->MascaraOrigen = $lReglaIptablesXML->MascaraOrigen;
						$lReglaIptables->Protocolo = $lReglaIptablesXML->Protocolo;
						$lReglaIptables->InterfazDestino->IP = $lReglaIptablesXML->InterfazDestino->IP;
						$lReglaIptables->InterfazDestino->Nombre = $lReglaIptablesXML->InterfazDestino->Nombre;
						$lDAOInterfaz = new DAOInterfaz($lReglaIptables->InterfazDestino);
						$lReglaIptables->InterfazDestino = $lDAOInterfaz->buscarNombre();
						$lReglaIptables->IPDestino = $lReglaIptablesXML->IPDestino;
						$lReglaIptables->MascaraDestino = $lReglaIptablesXML->MascaraDestino;
						$lReglaIptables->Accion->ID = $lReglaIptablesXML->Accion;
						$lReglaIptables->InterfazOrigen->IP = $lReglaIptablesXML->InterfazOrigen->IP;
						$lReglaIptables->InterfazOrigen->Nombre = $lReglaIptablesXML->InterfazOrigen->Nombre;
						$lDAOInterfaz = new DAOInterfaz($lReglaIptables->InterfazOrigen);
						$lReglaIptables->InterfazOrigen = $lDAOInterfaz->buscarNombre();
						$lReglaIptables->Estado->ID = $lReglaIptablesXML->Estado;
						$lReglaIptables->MAC = $lReglaIptablesXML->MAC;
						$lReglasIptables[] = $lReglaIptables;
					}
					$lCadena->ReglasIptables = $lReglasIptables;
					$lCadenas[] = $lCadena;
				}
				$lTabla->Cadenas = $lCadenas;
				$lTablas[] = $lTabla;
			}
			$this->aIptables->Tablas = $lTablas;
			
			$lReglasPredefinidas = array();
			foreach ($lXML->Iptables[0]->ReglasPredefinidas->ReglaPredefinida as $lReglaPredefinida) {
				$lRegla = new ReglaPredefinidaIptables();
				$lRegla->ID = $lReglaPredefinida->ID;
				$lRegla->Accion = new AccionIptables();
				$lRegla->Accion->ID = $lReglaPredefinida->Accion;
				foreach ($lReglaPredefinida->DetallesReglaPredefinida->DetalleReglaPredefinida as $lDetalleReglaPredefinida) {
					$lDetalle = new DetallereglaPredefinida();
					$lDetalle->ID = $lDetalleReglaPredefinida;
					$lRegla->DetalleReglaPredefinida[] = $lDetalle;
				}
				$lReglasPredefinidas[] = $lRegla;
			}
			$this->aIptables->ReglasPredefinidas = $lReglasPredefinidas;
			
			/* Agregando a la BD */
			$lDAOIptables = new DAOIptables($this->aIptables);
			$lDAOIptables->agregar();
			
			$lIptables = $lDAOIptables->buscarMaxID();
			
			$lDAOIptables = new DAOIptables($lIptables);
			$lDAOIptables->inicializarPoliticas();
			
			$lHistorico = new HistoricoIptables();
			$lHistorico->Iptables = $lIptables;
			$lHistorico->FechaCreacion = date("Ymd");
			$lHistorico->HoraCreacion = date("H:i");
			$lHistorico->Descripcion = $lIptables->Descripcion;
			
			$lDAOHistorico = new DAOHistoricoIptables($lHistorico);
			$lDAOHistorico->agregar();
			
			foreach ($this->aIptables->Tablas as $lTable) {
				foreach ($lTable->Cadenas as $lCadena) {
					$lDAOCadena = new DAOCadena($lCadena);
					$lDAOCadena->actualizarPoliticas($lIptables->ID, $lCadena->Politica->ID);
					foreach ($lCadena->ReglasIptables as $lRegla) {
						$lDAOReglaIptables = new DAOReglaIptables($lRegla);
						$lDAOReglaIptables->agregar( $lIptables->ID, $lCadena->ID );
					}
				}
			}
			
			foreach ($this->aIptables->ReglasPredefinidas as $lReglaPredefinida) {
				$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables($lReglaPredefinida);
				$lDAOReglaPredefinida->agregarReglaPredefinida($lIptables->ID, $lReglaPredefinida->Accion->ID);
			}
			
			$_SESSION['info'] = "El archivo ha sido importado exitosamente";
		} else {
			$_SESSION['error'] = "Se ha producido un error al importar el archivo";
		}
	}
	
	/**
	 * Contructor del objeto ControladorServidor
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		
	} // end of member function __construct

} // end of ControladorServidor
?>
