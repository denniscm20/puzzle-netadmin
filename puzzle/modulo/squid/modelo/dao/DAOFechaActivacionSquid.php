<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOFechaActivacionSquid.php
 * @class modulo/Squid/modelo/dao/DAOFechaActivacionSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."FechaActivacionSquid.php";

/**
 * class DAOFechaActivacionSquid
 */
class DAOFechaActivacionSquid extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::FechaActivacionSquid pFechaActivacionSquid 
	 * @return 
	 * @access public
	 */
	public function __construct( $pFechaActivacionSquid = null ) {
		parent::__construct($pFechaActivacionSquid, BASE_DATOS_SQUID);
	} // end of member function __construct

	/**
	 * Destructor de la clase.
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		
	} // end of member function __destruct

	/**
	 * Permite agregar nuevas FechaActivacionSquid a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( $pHistoricoSquidID ) {
		try {
			$this->aQuery = "INSERT INTO FechaActivacionSquid (HistoricoSquidID,FechaActivacion,HoraActivacion) VALUES (?,?,?)";
			$this->aParameters = array($pHistoricoSquidID, $this->aObjeto->FechaActivacion, $this->aObjeto->HoraActivacion);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregar

	/**
	 * Permite eliminar subredes registradas en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM FechaActivacionSquid WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar
	
	/**
	 * Permite eliminar subredes registradas en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminarPorHistorico( $pHistoricoSquidID ) {
		try {
			$this->aQuery = "DELETE FROM FechaActivacionSquid WHERE HistoricoSquidID = ?";
			$this->aParameters = array($pHistoricoSquidID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar

	public function listarPorHistorico( $pHistoricoSquidID ) {
		try {
			$this->aQuery = "SELECT * FROM FechaActivacionSquid WHERE HistoricoSquidID = ? ORDER BY FechaActivacion, HoraActivacion DESC";
			$this->aParameters = array($pHistoricoSquidID);
			$lResultados = $this->select();
	
			$lFechaActivacionSquides = array();
			foreach ($lResultados as $lResultado) {
				$lFechaActivacionSquides[] = $this->cargarObjeto($lResultado);
			}
			
			return $lFechaActivacionSquides;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lFechaActivacionSquid = new FechaActivacionSquid();
		$lFechaActivacionSquid->ID = $pResultado['ID'];
		$lFechaActivacionSquid->FechaActivacion = $pResultado['FechaActivacion'];
		$lFechaActivacionSquid->HoraActivacion = $pResultado['HoraActivacion'];
		
		return $lFechaActivacionSquid;
	}

} // end of DAOFechaActivacionSquid
?>
