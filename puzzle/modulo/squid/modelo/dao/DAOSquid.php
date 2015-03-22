<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOSquid.php
 * @class modulo/Squid/modelo/dao/DAOSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID.'Squid.php';
require_once CLASES_SQUID.'PuertoSquid.php';
require_once DAO_SQUID.'DAOPuertoSquid.php';
require_once DAO_SQUID.'DAOReglaPredefinida.php';
require_once DAO_SQUID.'DAOReglaSquid.php';

/**
 * class DAOSquid
 */
class DAOSquid extends DAO {

	/**
	 *
	 * @param modelo::clases::Squid pSquid 
	 * @return 
	 * @access public
	 */
	public function __construct( $pSquid = null ) {
		parent::__construct($pSquid, BASE_DATOS_SQUID);
	} // end of member function __construct

	public function __destruct() {
		parent::__destruct();
	}

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM Squid";
			$lResultados = $this->select();
	
			$lSquids = array();
			foreach ($lResultados as $lResultado) {
				$lSquids[] = $this->cargarObjeto($lResultado);
			}
			
			return $lSquids;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Squid WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Squid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarActivo( ) {
		try {
			$this->aQuery = "SELECT * FROM Squid WHERE Activo = 1";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Squid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function activar( ) {
		try {
			$this->aQuery = "UPDATE Squid SET Activo = 0";
			$this->aParameters = array();
			$this->update();
			
			$this->aQuery = "UPDATE Squid SET Activo = 1 WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID() {
		try {
			$this->aQuery = "SELECT * FROM Squid WHERE ID = (SELECT MAX(ID) FROM Squid)";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Squid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregar() {
		try {
			$this->aQuery = "UPDATE Squid SET Activo = 0";
			$this->aParameters = array();
			$this->update();
			
			$this->aQuery = "INSERT INTO Squid (IcpPort, CacheDir, CacheMaxSize, DirNumber1, DirNumber2, CacheLog, StoreLog, AccessLog, LogFqdn, DnsNameservers, VisibleHostname, Transparent, Activo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,1)";
			$this->aParameters = array($this->aObjeto->IcpPort, $this->aObjeto->CacheDir, $this->aObjeto->CacheMaxSize, $this->aObjeto->DirNumber1, $this->aObjeto->DirNumber2, $this->aObjeto->CacheLog, $this->aObjeto->StoreLog, $this->aObjeto->AccessLog, ($this->aObjeto->LogFqdn)?1:0, $this->aObjeto->DnsNameservers, $this->aObjeto->VisibleHostname, $this->aObjeto->Transparent?1:0);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar() {
		try {
			$this->aQuery = "DELETE FROM Squid WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lSquid = new Squid();
		$lSquid->ID = $pResultado['ID'];
		$lSquid->IcpPort = $pResultado['IcpPort'];
		$lSquid->CacheDir = $pResultado['CacheDir'];
		$lSquid->CacheMaxSize = $pResultado['CacheMaxSize'];
		$lSquid->DirNumber1 = $pResultado['DirNumber1'];
		$lSquid->DirNumber2 = $pResultado['DirNumber2'];
		$lSquid->CacheLog = $pResultado['CacheLog'];
		$lSquid->StoreLog = $pResultado['StoreLog'];
		$lSquid->AccessLog = $pResultado['AccessLog'];
		$lSquid->LogFqdn = $pResultado['LogFqdn'];
		$lSquid->DnsNameservers = $pResultado['DnsNameservers'];
		$lSquid->VisibleHostname = $pResultado['VisibleHostname'];
		$lSquid->Transparent = $pResultado['Transparent'];
		$lSquid->Activo = $pResultado['Activo'];
		
		$lDAOHttpPort = new DAOPuertoSquid();
		$lSquid->HttpPort = $lDAOHttpPort->listarPorSquid($lSquid->ID);
		
		$lDAOReglaSquid = new DAOReglaSquid();
		$lSquid->ReglasSquid = $lDAOReglaSquid->listarSquid($lSquid->ID);
		
		$lDAOReglaPredefinida = new DAOReglaPredefinida();
		$lSquid->ReglasPredefinidas = $lDAOReglaPredefinida->listarSquid($lSquid->ID);
		
		return $lSquid;
	}

} // end of DAOSquid
?>
