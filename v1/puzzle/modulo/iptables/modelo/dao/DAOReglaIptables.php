<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/dao/DAOReglaIptables.php
 * @class modulo/Iptables/modelo/dao/DAOReglaIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Interfaz.php';
require_once DAO_IPTABLES.'DAOAccion.php';
require_once DAO_IPTABLES.'DAOEstado.php';
require_once DAO_IPTABLES.'DAOProtocolo.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once CLASES_IPTABLES.'Estado.php';
require_once CLASES_IPTABLES.'Protocolo.php';

/**
 * class DAOReglaIptables
 */
class DAOReglaIptables extends DAO {

	/**
	 *
	 * @param modelo::clases::ReglaTable pReglaTable 
	 * @return 
	 * @access public
	 */
	public function __construct( $pReglaTable = null ) {
		parent::__construct($pReglaTable, BASE_DATOS_IPTABLES);
	} // end of member function __construct

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		
	} // end of member function __destruct

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarPorIptablesTablaCadena( $pIptablesID, $pTableID, $pCadenaID) {
		try {
			$this->aQuery = "SELECT A.* FROM ReglaIptables A LEFT JOIN Cadena B ON (A.CadenaID = B.ID) WHERE A.IptablesID = ? AND B.TableID = ? AND A.CadenaID = ?";
			$this->aParameters = array($pIptablesID,$pTableID,$pCadenaID);
			$lResultados = $this->select();
	
			$lReglaIptables = array();
			foreach ($lResultados as $lResultado) {
				$lReglaIptables[] = $this->cargarObjeto($lResultado);
			}
			
			return $lReglaIptables;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos

	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM 'ReglaIptables' WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Table();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM 'ReglaIptables' WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Table();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorIptables( $pIptablesID ) {
		try {
			$this->aQuery = "DELETE FROM 'ReglaIptables' WHERE IptablesID = ?";
			$this->aParameters = array($pIptablesID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Table();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregar( $pIptablesID, $pCadenaID ) {
		try {
			$this->aQuery = "INSERT INTO ReglaIptables (IptablesID, CadenaID, AccionID, PuertoOrigenInicial, PuertoOrigenFinal, PuertoDestinoInicial, PuertoDestinoFinal, IPOrigen, IPDestino, ProtocoloID, InterfazOrigenID, InterfazDestinoID, EstadoID, MAC, MascaraOrigen, MascaraDestino) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$this->aParameters = array($pIptablesID, $pCadenaID, $this->aObjeto->Accion->ID, $this->aObjeto->PuertoOrigenInicial, $this->aObjeto->PuertoOrigenFinal, $this->aObjeto->PuertoDestinoInicial, $this->aObjeto->PuertoDestinoFinal, $this->aObjeto->IPOrigen, $this->aObjeto->IPDestino, $this->aObjeto->Protocolo->ID, $this->aObjeto->InterfazOrigen->ID, $this->aObjeto->InterfazDestino->ID, $this->aObjeto->Estado->ID, $this->aObjeto->MAC, $this->aObjeto->MascaraOrigen, $this->aObjeto->MascaraDestino);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function habilitarProxyTransparente($pPuertosSquid) {
		try {
			$this->aQuery = "SELECT ID FROM Iptables WHERE Activo = 1";
			$this->aParameters = array();
			$lResultados = $this->select();
			
			$lIptablesID = 0;
			if ($lResultados) {
				$lIptablesID = $lResultados[0]["ID"];
			}
			
			foreach ($pPuertosSquid as $lPuerto) {
				$this->aQuery = "INSERT INTO ReglaIptables (IptablesID, CadenaID, AccionID, PuertoOrigenInicial, PuertoOrigenFinal, PuertoDestinoInicial, PuertoDestinoFinal, IPOrigen, IPDestino, ProtocoloID, InterfazOrigenID, InterfazDestinoID, EstadoID, MAC, MascaraOrigen, MascaraDestino) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$this->aParameters = array($lIptablesID, 4, 4, 80, "", $lPuerto, "", "", "", 1, 0, 0, 0, "", "", "");
				$this->insert();
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lReglaIptables = new ReglaIptables();
		$lReglaIptables->ID = $pResultado['ID'];
		
		$lAccion = new AccionIptables();
		$lAccion->ID = $pResultado['AccionID'];
		$lDAOAccion = new DAOAccionIptables($lAccion);
		$lReglaIptables->Accion = $lDAOAccion->buscarID();
		
		$lReglaIptables->PuertoOrigenInicial = $pResultado['PuertoOrigenInicial'];
		$lReglaIptables->PuertoOrigenFinal = $pResultado['PuertoOrigenFinal'];
		$lReglaIptables->PuertoDestinoInicial = $pResultado['PuertoDestinoInicial'];
		$lReglaIptables->PuertoDestinoFinal = $pResultado['PuertoDestinoFinal'];
		$lReglaIptables->MascaraOrigen = $pResultado['MascaraOrigen'];
		$lReglaIptables->IPOrigen = $pResultado['IPOrigen'];
		
		$lProtocolo = new Protocolo();
		$lProtocolo->ID = $pResultado['ProtocoloID'];
		$lDAOProtocolo = new DAOProtocolo($lProtocolo);
		$lReglaIptables->Protocolo = $lDAOProtocolo->buscarID();
		
		$lReglaIptables->MascaraDestino = $pResultado['MascaraDestino'];
		$lReglaIptables->IPDestino = $pResultado['IPDestino'];
		
		$lInterfaz = new Interfaz();
		$lInterfaz->ID = $pResultado['InterfazOrigenID'];
		$lDAOInterfaz = new DAOInterfaz($lInterfaz);
		$lReglaIptables->InterfazOrigen = $lDAOInterfaz->buscarID();
		$lInterfaz->ID = $pResultado['InterfazDestinoID'];
		$lDAOInterfaz = new DAOInterfaz($lInterfaz);
		$lReglaIptables->InterfazDestino = $lDAOInterfaz->buscarID();
		
		$lEstado = new Estado();
		$lEstado->ID = $pResultado['EstadoID'];
		$lDAOEstado = new DAOEstado($lEstado);
		$lReglaIptables->Estado = $lDAOEstado->buscarID();
		
		$lReglaIptables->MAC = $pResultado['MAC'];
		
		return $lReglaIptables;
	}

} // end of DAOReglaIptables
?>
