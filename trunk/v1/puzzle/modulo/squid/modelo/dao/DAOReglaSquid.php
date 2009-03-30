<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/ReglaSquid/modelo/dao/DAOReglaSquid.php
 * @class modulo/ReglaSquid/modelo/dao/DAOReglaSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID.'Accion.php';
require_once CLASES_SQUID.'TipoAcceso.php';
require_once CLASES_SQUID.'ReglaSquid.php';
require_once DAO_SQUID.'DAOAccion.php';
require_once DAO_SQUID.'DAOTipoAcceso.php';
require_once DAO_SQUID.'DAOListaControlAcceso.php';

/**
 * class DAOReglaSquid
 */
class DAOReglaSquid extends DAO {

	/**
	 *
	 * @param modelo::clases::ReglaSquid pReglaSquid 
	 * @return 
	 * @access public
	 */
	public function __construct( $pReglaSquid = null ) {
		parent::__construct($pReglaSquid, BASE_DATOS_SQUID);
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
	public function listarSquid( $pSquidID ) {
		try {
			$this->aQuery = "SELECT * FROM ReglaSquid WHERE SquidID = ?";
			$this->aParameters = array($pSquidID);
			$lResultados = $this->select();
	
			$lReglasSquids = array();
			foreach ($lResultados as $lResultado) {
				$lReglasSquids[] = $this->cargarObjeto($lResultado);
			}
			
			return $lReglasSquids;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM ReglaSquid WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new ReglaSquid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID( ) {
		try {
			$this->aQuery = "SELECT * FROM ReglaSquid WHERE ID = (SELECT MAX(ID) FROM ReglaSquid)";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new ReglaSquid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregar( $pSquidID ) {
		try {
			$this->aQuery = "INSERT INTO ReglaSquid (SquidID, AccionID, TipoAccesoID) VALUES (?, ?, ?)";
			$this->aParameters = array($pSquidID, $this->aObjeto->Accion->ID, $this->aObjeto->TipoAcceso->ID);
			$lResultados = $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( ) {
		try {
			$this->aQuery = "UPDATE ReglaSquid SET AccionID = 0 WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarCompletamente( ) {
		try {
			$this->aQuery = "DELETE FROM ReglaSquid WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorSquid( $pSquidID ) {
		try {
			$this->aQuery = "DELETE FROM ReglaSquid WHERE SquidID = ?";
			$this->aParameters = array($pSquidID);
			$lResultados = $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function actualizar( ) {
		try {
			$this->aQuery = "UPDATE ReglaSquid SET AccionID = ? WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->Accion->ID, $this->aObjeto->ID);
			$lResultados = $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lReglaSquid = new ReglaSquid();
		$lReglaSquid->ID = $pResultado['ID'];
		
		$lAccion = new Accion();
		$lAccion->ID = $pResultado['AccionID'];
		$lDAOAccion = new DAOAccion($lAccion);
		$lReglaSquid->Accion = $lDAOAccion->buscarID();
		
		$lTipoAcceso = new TipoAcceso();
		$lTipoAcceso->ID = $pResultado['TipoAccesoID'];
		$lDAOTipoAcceso = new DAOTipoAcceso($lTipoAcceso);
		$lReglaSquid->TipoAcceso = $lDAOTipoAcceso->buscarID();
		
		$lDAOListaControlAcceso = new DAOListaControlAcceso();
		$lReglaSquid->ListaControlAcceso = $lDAOListaControlAcceso->buscarReglaSquid($lReglaSquid->ID);

		return $lReglaSquid;
	}

} // end of DAOReglaSquid
?>
