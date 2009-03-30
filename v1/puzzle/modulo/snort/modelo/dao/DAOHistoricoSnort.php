<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOHistoricoSnort.php
 * @class modulo/Snort/modelo/dao/DAOHistoricoSnort.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."HistoricoSnort.php";
require_once CLASES_SNORT."Snort.php";
require_once DAO_SNORT."DAOFechaActivacionSnort.php";
require_once DAO_SNORT."DAOSnort.php";

/**
 * class DAOHistoricoSnort
 */
class DAOHistoricoSnort extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::HistoricoSnort pHistoricoSnort 
	 * @return 
	 * @access public
	 */
	public function __construct( $pHistoricoSnort = null ) {
		parent::__construct($pHistoricoSnort, BASE_DATOS_SNORT);
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
	 * Permite agregar nuevas HistoricoSnort a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$this->aQuery = "INSERT INTO HistoricoSnort (SnortID,FechaCreacion,HoraCreacion,Descripcion) VALUES (?,?,?,?)";
			$this->aParameters = array($this->aObjeto->Snort->ID, $this->aObjeto->FechaCreacion, $this->aObjeto->HoraCreacion, $this->aObjeto->Descripcion);
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
			$this->aQuery = "DELETE FROM HistoricoSnort WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar

	/**
	 * Permite buscar todas las subredes que cumplan con el criterio de búsqueda.
	 *
	 * @return 
	 * @access public
	 */
	public function listarPorFecha( $pFechaInicial, $pFechaFinal ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSnort WHERE FechaCreacion >= ? AND FechaCreacion <= ?";
			$this->aParameters = array($pFechaInicial, $pFechaFinal);
			$lResultados = $this->select();
	
			$lHistoricoSnortes = array();
			foreach ($lResultados as $lResultado) {
				$lHistoricoSnortes[] = $this->cargarObjeto($lResultado);
			}
			
			return $lHistoricoSnortes;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	/**
	 * Permite buscar todas las subredes que cumplan con el criterio de búsqueda.
	 *
	 * @return 
	 * @access public
	 */
	public function listarPorSnort( $pSnortID ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSnort WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultado = $this->select();
	
			$lHistoricoSnort = new HistoricoSnort();
			if ($lResultado) {
				$lHistoricoSnort = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lHistoricoSnort;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSnort";
			$lResultados = $this->select();
	
			$lHistoricoSnortes = array();
			foreach ($lResultados as $lResultado) {
				$lHistoricoSnortes[] = $this->cargarObjeto($lResultado);
			}
			
			return $lHistoricoSnortes;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 *
	 * @return modelo::clases::HistoricoSnort
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSnort WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();

			$lHistoricoSnort = new HistoricoSnort();
			if ($lResultado) {
				$lHistoricoSnort = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lHistoricoSnort;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
			
	protected function cargarObjeto ($pResultado) {
		$lHistoricoSnort = new HistoricoSnort();
		$lHistoricoSnort->ID = $pResultado['ID'];
		
		$lSnort = new Snort();
		$lSnort->ID = $pResultado['SnortID'];
		$lDAOSnort = new DAOSnort($lSnort);
		$lHistoricoSnort->Snort = $lDAOSnort->buscarID();
		
		$lHistoricoSnort->FechaCreacion = $pResultado['FechaCreacion'];
		$lHistoricoSnort->HoraCreacion = $pResultado['HoraCreacion'];
		$lHistoricoSnort->Descripcion = $pResultado['Descripcion'];
		
		$lDAOFechaActivacionSnort = new DAOFechaActivacionSnort();
		$lHistoricoSnort->FechasAplicacionSnort = $lDAOFechaActivacionSnort->listarPorHistorico($lHistoricoSnort->ID);
		
		return $lHistoricoSnort;
	}

} // end of DAOHistoricoSnort
?>

