<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/dao/DAOIptables.php
 * @class modulo/Iptables/modelo/dao/DAOIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once CLASES_IPTABLES.'Table.php';
require_once CLASES_IPTABLES.'Cadena.php';
require_once DAO_IPTABLES.'DAOTable.php';
require_once DAO_IPTABLES.'DAOCadena.php';
require_once DAO_IPTABLES.'DAOReglaPredefinida.php';

/**
 * class DAOIptables
 */
class DAOIptables extends DAO {

	/**
	 *
	 * @param modelo::clases::Iptables pIptables 
	 * @return 
	 * @access public
	 */
	public function __construct( $pIptables = null ) {
		parent::__construct($pIptables, BASE_DATOS_IPTABLES);
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
			$this->aQuery = "SELECT * FROM Iptables";
			$lResultados = $this->select();
	
			$lIptabless = array();
			foreach ($lResultados as $lResultado) {
				$lIptabless[] = $this->cargarObjeto($lResultado);
			}
			
			return $lIptabless;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Iptables WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Iptables();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarActivo( ) {
		try {
			$this->aQuery = "SELECT * FROM Iptables WHERE Activo = 1";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Iptables();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function activar( ) {
		try {
			$this->aQuery = "UPDATE Iptables SET Activo = 0";
			$this->aParameters = array();
			$this->update();
			
			$this->aQuery = "UPDATE Iptables SET Activo = 1 WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID() {
		try {
			$this->aQuery = "SELECT * FROM Iptables WHERE ID = (SELECT MAX(ID) FROM Iptables)";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Iptables();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function inicializarPoliticas() {
		try {
			$this->aQuery = "INSERT INTO IptablesXCadenaXPolitica (IptablesID, CadenaID, PoliticaID) SELECT ?, ID, 0 FROM Cadena";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregar() {
		try {
			$this->aQuery = "UPDATE Iptables SET Activo = 0";
			$this->aParameters = array();
			$this->update();
			
			$this->aQuery = "INSERT INTO Iptables (Descripcion, Activo) VALUES (?,1)";
			$this->aParameters = array($this->aObjeto->Descripcion);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar() {
		try {
			$this->aQuery = "DELETE FROM IptablesXCadenaXPolitica WHERE IptablesID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$this->delete();
			
			$this->aQuery = "DELETE FROM Iptables WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lIptables = new Iptables();
		$lIptables->ID = $pResultado['ID'];
		$lIptables->Descripcion = $pResultado['Descripcion'];
		
		$lDAOTable = new DAOTable();
		$lIptables->Tablas = $lDAOTable->listarTodos($lIptables->ID);
		
		$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables();
		$lIptables->ReglasPredefinidas = $lDAOReglaPredefinida->listarPorIptables($lIptables->ID);
		
		return $lIptables;
	}

} // end of DAOIptables
?>
