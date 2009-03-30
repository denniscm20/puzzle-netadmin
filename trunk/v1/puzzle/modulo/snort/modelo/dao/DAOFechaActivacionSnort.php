<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOFechaActivacionSnort.php
 * @class modulo/Snort/modelo/dao/DAOFechaActivacionSnort.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."FechaAplicacionSnort.php";

/**
 * class DAOFechaActivacionSnort
 */
class DAOFechaActivacionSnort extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::FechaActivacionSnort pFechaActivacionSnort 
	 * @return 
	 * @access public
	 */
	public function __construct( $pFechaActivacionSnort = null ) {
		parent::__construct($pFechaActivacionSnort, BASE_DATOS_SNORT);
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
	 * Permite agregar nuevas FechaActivacionSnort a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( $pHistoricoSnortID ) {
		try {
			$this->aQuery = "INSERT INTO FechaActivacionSnort (HistoricoSnortID,FechaActivacion,HoraActivacion) VALUES (?,?,?)";
			$this->aParameters = array($pHistoricoSnortID, $this->aObjeto->FechaAplicacion, $this->aObjeto->HoraAplicacion);
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
			$this->aQuery = "DELETE FROM FechaActivacionSnort WHERE ID = ?";
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
	public function eliminarPorHistorico( $pHistoricoSnortID ) {
		try {
			$this->aQuery = "DELETE FROM FechaActivacionSnort WHERE HistoricoSnortID = ?";
			$this->aParameters = array($pHistoricoSnortID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar

	public function listarPorHistorico( $pHistoricoSnortID ) {
		try {
			$this->aQuery = "SELECT * FROM FechaActivacionSnort WHERE HistoricoSnortID = ? ORDER BY FechaActivacion, HoraActivacion DESC";
			$this->aParameters = array($pHistoricoSnortID);
			$lResultados = $this->select();
	
			$lFechaActivacionSnortes = array();
			foreach ($lResultados as $lResultado) {
				$lFechaActivacionSnortes[] = $this->cargarObjeto($lResultado);
			}
			
			return $lFechaActivacionSnortes;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lFechaActivacionSnort = new FechaAplicacionSnort();
		$lFechaActivacionSnort->ID = $pResultado['ID'];
		$lFechaActivacionSnort->FechaAplicacion = $pResultado['FechaActivacion'];
		$lFechaActivacionSnort->HoraAplicacion = $pResultado['HoraActivacion'];
		
		return $lFechaActivacionSnort;
	}

} // end of DAOFechaActivacionSnort
?>
