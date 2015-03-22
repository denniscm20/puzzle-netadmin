<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOListaControlAcceso.php
 * @class modulo/Squid/modelo/dao/DAOListaControlAcceso.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."ListaControlAcceso.php";
require_once CLASES_SQUID."TipoACL.php";
require_once DAO_SQUID."DAOTipoACL.php";
require_once DAO_SQUID."DAOValor.php";

/**
 * class DAOListaControlAcceso
 */
class DAOListaControlAcceso extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::ListaControlAcceso pListaControlAcceso 
	 * @return 
	 * @access public
	 */
	public function __construct( $pListaControlAcceso = null ) {
		parent::__construct($pListaControlAcceso, BASE_DATOS_SQUID);
	} // end of member function __construct

	/**
	 * Destructor de la clase.
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		
	} // end of member function __destruct

	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM ListaControlAcceso WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lListaControlAcceso = new ListaControlAcceso();
			if ($lResultado) {
				$lListaControlAcceso = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lListaControlAcceso;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function agregar( $pReglaSquidID ) {
		try {
			$this->aQuery = "INSERT INTO ListaControlAcceso (ReglaSquidID, TipoACLID, Nombre) Values (?, ?, ?)";
			$this->aParameters = array($pReglaSquidID,$this->aObjeto->TipoACL->ID,$this->aObjeto->Nombre);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM ListaControlAcceso WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID( ) {
		try {
			$this->aQuery = "SELECT * FROM ListaControlAcceso WHERE ID = (SELECT MAX(ID) FROM ListaControlAcceso)";
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
	
	public function listarNombresRegistrados( $pSquidID ) {
		try {
			$this->aQuery = "SELECT DISTINCT(L.Nombre) 'Nombre', L.ID 'ID', L.ReglaSquidID 'ReglaSquidID', L.TipoACLID 'TipoACLID' FROM ListaControlAcceso AS L LEFT JOIN ReglaSquid AS R ON (R.ID = L.ReglaSquidID) LEFT JOIN Squid AS S ON (S.ID = R.SquidID) WHERE S.ID = ? GROUP BY L.Nombre";
			$this->aParameters = array($pSquidID);
			$lResultados = $this->select();
	
			$lTiposACL = array();
			foreach ($lResultados as $lResultado) {
				$lTiposACL[] = $this->cargarObjeto($lResultado);
			}
			
			return $lTiposACL;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarSquid( $pSquidID ) {
		try {
			$this->aQuery = "SELECT L.* FROM ListaControlAcceso AS L LEFT JOIN ReglaSquid AS R ON (R.ID = L.ReglaSquidID) WHERE R.SquidID = ?";
			$this->aParameters = array($pSquidID);
			$lResultados = $this->select();
	
			$lTiposACL = array();
			foreach ($lResultados as $lResultado) {
				$lTiposACL[] = $this->cargarObjeto($lResultado);
			}
			
			return $lTiposACL;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarReglaSquid( $pReglaSquidID ) {
		try {
			$this->aQuery = "SELECT * FROM ListaControlAcceso WHERE ReglaSquidID = ?";
			$this->aParameters = array($pReglaSquidID);
			$lResultado = $this->select();
	
			$lListaControlAcceso = new ListaControlAcceso();
			if ($lResultado) {
				$lListaControlAcceso = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lListaControlAcceso;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarSinReglaSquid( ) {
		try {
			$this->aQuery = "SELECT * FROM ListaControlAcceso WHERE ReglaSquidID = 0";
			$this->aParameters = array();
			$lResultado = $this->select();
	
			$lACL = array();
			foreach ($lResultados as $lResultado) {
				$lACL[] = $this->cargarObjeto($lResultado);
			}
		
			return $lACL;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lListaControlAcceso = new ListaControlAcceso();
		$lListaControlAcceso->ID = $pResultado['ID'];
		$lListaControlAcceso->Nombre = $pResultado['Nombre'];
		
		$lTipoACL = new TipoACL();
		$lTipoACL->ID = $pResultado['TipoACLID'];
		$lDAOTipoACL = new DAOTipoACL($lTipoACL);
		$lListaControlAcceso->TipoACL = $lDAOTipoACL->buscarID();
		
		$lDAOValor = new DAOValor();
		$lListaControlAcceso->Valores = $lDAOValor->listarACL($lListaControlAcceso->ID);
		
		return $lListaControlAcceso;
	}

} // end of DAOListaControlAcceso
?>
