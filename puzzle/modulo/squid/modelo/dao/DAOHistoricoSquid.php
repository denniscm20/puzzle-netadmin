<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOHistoricoSquid.php
 * @class modulo/Squid/modelo/dao/DAOHistoricoSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."HistoricoSquid.php";
require_once CLASES_SQUID."Squid.php";
require_once DAO_SQUID."DAOFechaActivacionSquid.php";
require_once DAO_SQUID."DAOSquid.php";

/**
 * class DAOHistoricoSquid
 */
class DAOHistoricoSquid extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::HistoricoSquid pHistoricoSquid 
	 * @return 
	 * @access public
	 */
	public function __construct( $pHistoricoSquid = null ) {
		parent::__construct($pHistoricoSquid, BASE_DATOS_SQUID);
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
	 * Permite agregar nuevas HistoricoSquid a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$this->aQuery = "INSERT INTO HistoricoSquid (SquidID,FechaCreacion,HoraCreacion,Descripcion) VALUES (?,?,?,?)";
			$this->aParameters = array($this->aObjeto->Squid->ID, $this->aObjeto->FechaCreacion, $this->aObjeto->HoraCreacion, $this->aObjeto->Descripcion);
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
			$this->aQuery = "DELETE FROM HistoricoSquid WHERE ID = ?";
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
			$this->aQuery = "SELECT * FROM HistoricoSquid WHERE FechaCreacion >= ? AND FechaCreacion <= ?";
			$this->aParameters = array($pFechaInicial, $pFechaFinal);
			$lResultados = $this->select();
	
			$lHistoricoSquides = array();
			foreach ($lResultados as $lResultado) {
				$lHistoricoSquides[] = $this->cargarObjeto($lResultado);
			}
			
			return $lHistoricoSquides;
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
	public function listarPorSquid( $pSquidID ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSquid WHERE SquidID = ?";
			$this->aParameters = array($pSquidID);
			$lResultado = $this->select();
	
			$lHistoricoSquid = new HistoricoSquid();
			if ($lResultado) {
				$lHistoricoSquid = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lHistoricoSquid;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSquid";
			$lResultados = $this->select();
	
			$lHistoricoSquides = array();
			foreach ($lResultados as $lResultado) {
				$lHistoricoSquides[] = $this->cargarObjeto($lResultado);
			}
			
			return $lHistoricoSquides;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 *
	 * @return modelo::clases::HistoricoSquid
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoSquid WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();

			$lHistoricoSquid = new HistoricoSquid();
			if ($lResultado) {
				$lHistoricoSquid = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lHistoricoSquid;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
			
	protected function cargarObjeto ($pResultado) {
		$lHistoricoSquid = new HistoricoSquid();
		$lHistoricoSquid->ID = $pResultado['ID'];
		
		$lSquid = new Squid();
		$lSquid->ID = $pResultado['SquidID'];
		$lDAOSquid = new DAOSquid($lSquid);
		$lHistoricoSquid->Squid = $lDAOSquid->buscarID();
		
		$lHistoricoSquid->FechaCreacion = $pResultado['FechaCreacion'];
		$lHistoricoSquid->HoraCreacion = $pResultado['HoraCreacion'];
		$lHistoricoSquid->Descripcion = $pResultado['Descripcion'];
		
		$lDAOFechaActivacionSquid = new DAOFechaActivacionSquid();
		$lHistoricoSquid->FechasActivacionSquid = $lDAOFechaActivacionSquid->listarPorHistorico($lHistoricoSquid->ID);
		
		return $lHistoricoSquid;
	}

} // end of DAOHistoricoSquid
?>
