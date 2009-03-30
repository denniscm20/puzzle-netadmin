<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOReglaPredefinida.php
 * @class modelo/dao/DAOReglaPredefinida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'ReglaPredefinida.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once DAO_IPTABLES.'DAOAccion.php';
require_once DAO_IPTABLES.'DAODetalleReglaPredefinida.php';

/**
 * class DAOReglaPredefinida
 */
class DAOReglaPredefinidaIptables extends DAO {

	/**
	 *
	 * @param modelo::clases::ReglaPredefinida pReglaPredefinida 
	 * @return 
	 * @access public
	 */
	public function __construct( $pReglaPredefinida = null ) {
		parent::__construct($pReglaPredefinida, BASE_DATOS_IPTABLES);
	} // end of member function __construct

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		
	} // end of member function __destruct

	public function agregarReglaPredefinida ($pIptablesID, $pAccionID) {
		try {
			$this->aQuery = "INSERT INTO IptablesXReglaPredefinidaXAccion (IptablesID,ReglaPredefinidaID,AccionID) VALUES (?,?,?)";
			$this->aParameters = array($pIptablesID, $this->aObjeto->ID, $pAccionID);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregarRegla ($pReglaSquidID) {
		try {
			$this->aQuery = "SELECT ID FROM Iptables WHERE Activo = 1";
			$this->aParameters = array();
			$lResultados = $this->select();
			
			$lIptablesID = 0;
			if ($lResultados) {
				$lIptablesID = $lResultados[0]["ID"];
			}
			
			$this->aQuery = "SELECT * FROM ReglaPredefinidaIptablesXReglaPredefinidaSquid WHERE ReglaPredefinidaSquidID = ?";
			$this->aParameters = array($pReglaSquidID);
			$lResultados  = $this->select();
			foreach ($lResultados as $lResultado) {
				$lReglaID = $lResultado['ReglaPredefinidaIptablesID'];
				$this->aQuery = "SELECT COUNT(*) 'Contador' FROM IptablesXReglaPredefinidaXAccion WHERE ReglaPredefinidaID = ? AND IptablesID = ?";
				$this->aParameters = array($lReglaID, $lIptablesID);
				$lResultados = $this->select();
				
				if ($lResultados[0]["Contador"] == 0) {
					$this->aQuery = "INSERT INTO IptablesXReglaPredefinidaXAccion (IptablesID, ReglaPredefinidaID,AccionID) VALUES (?,?,?)";
					$this->aParameters = array($lIptablesID, $lReglaID, 1);
					$this->insert();
				}
			}
			
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarPorCategoriaIptables( $pCategoriaID, $pIptablesID) {
		try {
			$this->aQuery = "SELECT R.*,A.AccionID FROM IptablesXReglaPredefinidaXAccion A LEFT JOIN ReglaPredefinida R ON (A.ReglaPredefinidaID = R.ID) WHERE R.CategoriaID = ? AND A.IptablesID = ?";
			$this->aParameters = array($pCategoriaID,$pIptablesID);
			$lResultados = $this->select();
	
			$lReglaPredefinidas = array();
			foreach ($lResultados as $lResultado) {
				$lReglaPredefinida = $this->cargarObjeto($lResultado);
				$lReglaPredefinidas[] = $lReglaPredefinida;
			}
			
			return $lReglaPredefinidas;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarPorIptables( $pIptablesID ) {
		try {
			$this->aQuery = "SELECT R.*,A.AccionID FROM IptablesXReglaPredefinidaXAccion A LEFT JOIN ReglaPredefinida R ON (A.ReglaPredefinidaID = R.ID) WHERE A.IptablesID = ?";
			$this->aParameters = array($pIptablesID);
			$lResultados = $this->select();
	
			$lReglaPredefinidas = array();
			foreach ($lResultados as $lResultado) {
				$lReglaPredefinida = $this->cargarObjeto($lResultado);
				$lReglaPredefinidas[] = $lReglaPredefinida;
			}
			
			return $lReglaPredefinidas;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorReglaPredefinidaIptables($pIptablesID) {
		try {
			$this->aQuery = "DELETE FROM IptablesXReglaPredefinidaXAccion WHERE ReglaPredefinidaID = ? AND IptablesID = ?";
			$this->aParameters = array($this->aObjeto->ID,$pIptablesID);
			$lResultados = $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorIptables($pIptablesID) {
		try {
			$this->aQuery = "DELETE FROM IptablesXReglaPredefinidaXAccion WHERE IptablesID = ?";
			$this->aParameters = array($pIptablesID);
			$lResultados = $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarPorCategoria( $pCategoriaID) {
		try {
			$this->aQuery = "SELECT * FROM ReglaPredefinida WHERE CategoriaID = ?";
			$this->aParameters = array($pCategoriaID);
			$lResultados = $this->select();
	
			$lReglaPredefinidas = array();
			foreach ($lResultados as $lResultado) {
				$lReglaPredefinidas[] = $this->cargarObjeto($lResultado);
			}
			
			return $lReglaPredefinidas;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	protected function cargarObjeto($pResultado) {
		$lReglaPredefinida = new ReglaPredefinidaIptables();
		$lReglaPredefinida->ID = $pResultado['ID'];
		$lReglaPredefinida->Nombre = $pResultado['Nombre'];
		
		if (isset($pResultado['AccionID'])) {
			$lAccion = new AccionIptables();
			$lAccion->ID = $pResultado['AccionID'];
			$lDAOAccion = new DAOAccionIptables($lAccion);
			$lReglaPredefinida->Accion = $lDAOAccion->buscarID();
		}
		
		$lDAODetalleReglaPredefinida = new DAODetalleReglaPredefinida();
		$lReglaPredefinida->DetalleReglaPredefinida = $lDAODetalleReglaPredefinida->listarPorReglaPredefinida($lReglaPredefinida->ID);
		
		return $lReglaPredefinida;
	}

} // end of DAOReglaPredefinida
?>
