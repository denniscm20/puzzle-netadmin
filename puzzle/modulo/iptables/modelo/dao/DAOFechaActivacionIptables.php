<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/dao/DAOFechaActivacionIptables.php
 * @class modulo/Iptables/modelo/dao/DAOFechaActivacionIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES."FechaActivacionIptables.php";

/**
 * class DAOFechaActivacionIptables
 */
class DAOFechaActivacionIptables extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::FechaActivacionIptables pFechaActivacionIptables 
	 * @return 
	 * @access public
	 */
	public function __construct( $pFechaActivacionIptables = null ) {
		parent::__construct($pFechaActivacionIptables, BASE_DATOS_IPTABLES);
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
	 * Permite agregar nuevas FechaActivacionIptables a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( $pHistoricoIptablesID ) {
		try {
			$this->aQuery = "INSERT INTO FechaActivacionIptables (HistoricoIptablesID,FechaActivacion,HoraActivacion) VALUES (?,?,?)";
			$this->aParameters = array($pHistoricoIptablesID, $this->aObjeto->FechaActivacion, $this->aObjeto->HoraActivacion);
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
			$this->aQuery = "DELETE FROM FechaActivacionIptables WHERE ID = ?";
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
	public function eliminarPorHistorico( $pHistoricoIptablesID ) {
		try {
			$this->aQuery = "DELETE FROM FechaActivacionIptables WHERE HistoricoIptablesID = ?";
			$this->aParameters = array($pHistoricoIptablesID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar

	public function listarPorHistorico( $pHistoricoIptablesID ) {
		try {
			$this->aQuery = "SELECT * FROM FechaActivacionIptables WHERE HistoricoIptablesID = ? ORDER BY FechaActivacion, HoraActivacion DESC";
			$this->aParameters = array($pHistoricoIptablesID);
			$lResultados = $this->select();
	
			$lFechaActivacionIptableses = array();
			foreach ($lResultados as $lResultado) {
				$lFechaActivacionIptableses[] = $this->cargarObjeto($lResultado);
			}
			
			return $lFechaActivacionIptableses;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lFechaActivacionIptables = new FechaActivacionIptables();
		$lFechaActivacionIptables->ID = $pResultado['ID'];
		$lFechaActivacionIptables->FechaActivacion = $pResultado['FechaActivacion'];
		$lFechaActivacionIptables->HoraActivacion = $pResultado['HoraActivacion'];
		
		return $lFechaActivacionIptables;
	}

} // end of DAOFechaActivacionIptables
?>
