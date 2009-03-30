<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOReglaPredefinida.php
 * @class modulo/Snort/modelo/dao/DAOReglaPredefinida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."ReglaPredefinida.php";

/**
 * class DAOReglaPredefinida
 */
class DAOReglaPredefinida extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::ReglaPredefinida pReglaPredefinida 
	 * @return 
	 * @access public
	 */
	public function __construct( $pReglaPredefinida = null ) {
		parent::__construct($pReglaPredefinida, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM ReglaPredefinida WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lReglaPredefinida = new ReglaPredefinida();
			if ($lResultado) {
				$lReglaPredefinida = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lReglaPredefinida;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function agregar( $pSnortID ) {
		try {
			$this->aQuery = "INSERT INTO SnortXReglaPredefinida (SnortID, ReglaPredefinidaID) VALUES (?,?)";
			$this->aParameters = array($pSnortID, $this->aObjeto->ID);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( $pSnortID ) {
		try {
			$this->aQuery = "DELETE FROM SnortxReglaPredefinida WHERE SnortID = ? AND ReglaPredefinidaID = ?";
			$this->aParameters = array($pSnortID, $this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorSnort( $pSnortID ) {
		try {
			$this->aQuery = "DELETE FROM SnortxReglaPredefinida WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarSnort( $pSnortID ) {
		try {
			$this->aQuery = "SELECT R.* FROM SnortxReglaPredefinida S LEFT JOIN ReglaPredefinida R ON S.ReglaPredefinidaID = R.ID WHERE S.SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
	
			$lReglasPredefinidas = array();
			foreach ($lResultados as $lResultado) {
				$lReglasPredefinidas[] = $this->cargarObjeto($lResultado);
			}
		
			return $lReglasPredefinidas;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarNoSnort( $pSnortID ) {
		try {
			$this->aQuery = "SELECT * FROM ReglaPredefinida WHERE ID NOT IN (SELECT ReglaPredefinidaID FROM SnortxReglaPredefinida WHERE SnortID = ?)";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
	
			$lReglasPredefinidas = array();
			foreach ($lResultados as $lResultado) {
				$lReglasPredefinidas[] = $this->cargarObjeto($lResultado);
			}

			return $lReglasPredefinidas;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM ReglaPredefinida";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lReglasPredefinidas = array();
			foreach ($lResultados as $lResultado) {
				$lReglasPredefinidas[] = $this->cargarObjeto($lResultado);
			}
		
			return $lReglasPredefinidas;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lReglaPredefinida = new ReglaPredefinida();
		$lReglaPredefinida->ID = $pResultado['ID'];
		$lReglaPredefinida->Nombre = $pResultado['Nombre'];
		$lReglaPredefinida->Descripcion = $pResultado['Descripcion'];
		$lReglaPredefinida->Regla = $pResultado['Regla'];
		
		return $lReglaPredefinida;
	}

} // end of DAOReglaPredefinida
?>
