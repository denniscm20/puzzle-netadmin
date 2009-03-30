<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/PuertoSquid/modelo/dao/DAOPuertoSquid.php
 * @class modulo/PuertoSquid/modelo/dao/DAOPuertoSquid.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES_SQUID.'PuertoSquid.php';
require_once CLASES.'Interfaz.php';
require_once DAO.'DAOInterfaz.php';
require_once BASE.'DAO.php';

/**
 * class DAOPuertoSquid
 */
class DAOPuertoSquid extends DAO {
	/**
	 *
	 * @param modelo::clases::PuertoSquid pPuertoSquid 
	 * @return 
	 * @access public
	 */
	public function __construct( $pPuertoSquid = null ) {
		parent::__construct($pPuertoSquid, BASE_DATOS_SQUID);
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
	public function listarTodos( $pIptablesID = 0 ) {
		try {
			$this->aQuery = "SELECT * FROM 'PuertoSquid'";
			$lResultados = $this->select();
	
			$lPuertoSquids = array();
			foreach ($lResultados as $lResultado) {
				$lPuertoSquids[] = $this->cargarObjeto($lResultado, $pIptablesID);
			}
			
			return $lPuertoSquids;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarPorSquid( $pSquidID ) {
		try {
			$this->aQuery = "SELECT * FROM 'PuertoSquid' Where SquidID = ?";
			$this->aParameters = array($pSquidID);
			$lResultados = $this->select();
	
			$lPuertoSquids = array();
			foreach ($lResultados as $lResultado) {
				$lPuertoSquids[] = $this->cargarObjeto($lResultado);
			}
			
			return $lPuertoSquids;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM 'PuertoSquid' WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new PuertoSquid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregar( $pSquidID ) {
		try {
			$this->aQuery = "INSERT INTO PuertoSquid (InterfazID, SquidID, Puerto, Descripcion) VALUES (?,?,?,?)";
			$this->aParameters = array($this->aObjeto->Interfaz->ID,$pSquidID,$this->aObjeto->Puerto,$this->aObjeto->Descripcion);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new PuertoSquid();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorSquid( $pSquidID ) {
		try {
			$this->aQuery = "DELETE FROM PuertoSquid WHERE SquidID = ?";
			$this->aParameters = array($pSquidID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lPuertoSquid = new PuertoSquid();
		$lPuertoSquid->ID = $pResultado['ID'];
		$lPuertoSquid->Puerto = $pResultado['Puerto'];
		$lPuertoSquid->Descripcion = $pResultado['Descripcion'];
		
		$lInterfaz = new Interfaz();
		$lInterfaz->ID = $pResultado['InterfazID'];
		$lDAOInterfaz = new DAOInterfaz($lInterfaz);
		$lPuertoSquid->Interfaz = $lDAOInterfaz->buscarID();

		return $lPuertoSquid;
	}

} // end of DAOTabla
?>
