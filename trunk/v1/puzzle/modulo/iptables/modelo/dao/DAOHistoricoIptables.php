<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/dao/DAOHistoricoIptables.php
 * @class modulo/Iptables/modelo/dao/DAOHistoricoIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES."HistoricoIptables.php";
require_once CLASES_IPTABLES."Iptables.php";
require_once DAO_IPTABLES."DAOFechaActivacionIptables.php";
require_once DAO_IPTABLES."DAOIptables.php";

/**
 * class DAOHistoricoIptables
 */
class DAOHistoricoIptables extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::HistoricoIptables pHistoricoIptables 
	 * @return 
	 * @access public
	 */
	public function __construct( $pHistoricoIptables = null ) {
		parent::__construct($pHistoricoIptables, BASE_DATOS_IPTABLES);
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
	 * Permite agregar nuevas HistoricoIptables a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$this->aQuery = "INSERT INTO HistoricoIptables (IptablesID,FechaCreacion,HoraCreacion,Descripcion) VALUES (?,?,?,?)";
			$this->aParameters = array($this->aObjeto->Iptables->ID, $this->aObjeto->FechaCreacion, $this->aObjeto->HoraCreacion, $this->aObjeto->Descripcion);
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
			$this->aQuery = "DELETE FROM HistoricoIptables WHERE ID = ?";
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
			$this->aQuery = "SELECT * FROM HistoricoIptables  WHERE FechaCreacion >= ? AND FechaCreacion <= ?";
			$this->aParameters = array($pFechaInicial, $pFechaFinal);
			$lResultados = $this->select();
	
			$lHistoricoIptableses = array();
			foreach ($lResultados as $lResultado) {
				$lHistoricoIptableses[] = $this->cargarObjeto($lResultado);
			}
			
			return $lHistoricoIptableses;
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
	public function listarPorIptables( $pIptablesID ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoIptables WHERE IptablesID = ?";
			$this->aParameters = array($pIptablesID);
			$lResultado = $this->select();
	
			$lHistoricoIptables = new HistoricoIptables();
			if ($lResultado) {
				$lHistoricoIptables = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lHistoricoIptables;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoIptables";
			$lResultados = $this->select();
	
			$lHistoricoIptableses = array();
			foreach ($lResultados as $lResultado) {
				$lHistoricoIptableses[] = $this->cargarObjeto($lResultado);
			}
			
			return $lHistoricoIptableses;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 *
	 * @return modelo::clases::HistoricoIptables
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM HistoricoIptables WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();

			$lHistoricoIptables = new HistoricoIptables();
			if ($lResultado) {
				$lHistoricoIptables = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lHistoricoIptables;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
			
	protected function cargarObjeto ($pResultado) {
		$lHistoricoIptables = new HistoricoIptables();
		$lHistoricoIptables->ID = $pResultado['ID'];
		
		$lIptables = new Iptables();
		$lIptables->ID = $pResultado['IptablesID'];
		$lDAOIptables = new DAOIptables($lIptables);
		$lHistoricoIptables->Iptables = $lDAOIptables->buscarID();
		
		$lHistoricoIptables->FechaCreacion = $pResultado['FechaCreacion'];
		$lHistoricoIptables->HoraCreacion = $pResultado['HoraCreacion'];
		$lHistoricoIptables->Descripcion = $pResultado['Descripcion'];
		
		$lDAOFechaActivacionIptables = new DAOFechaActivacionIptables();
		$lHistoricoIptables->FechasActivacionIptables = $lDAOFechaActivacionIptables->listarPorHistorico($lHistoricoIptables->ID);
		
		return $lHistoricoIptables;
	}

} // end of DAOHistoricoIptables
?>
