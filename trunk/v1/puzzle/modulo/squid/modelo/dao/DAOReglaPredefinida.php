<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOReglaPredefinida.php
 * @class modulo/Squid/modelo/dao/DAOReglaPredefinida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."ReglaPredefinida.php";

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
		parent::__construct($pReglaPredefinida, BASE_DATOS_SQUID);
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
			
	public function agregar( $pSquidID ) {
		try {
			$this->aQuery = "INSERT INTO SquidxReglaPredefinida (SquidID, ReglaPredefinidaID) VALUES (?,?)";
			$this->aParameters = array($pSquidID, $this->aObjeto->ID);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregarRegla ($pReglaIptablesID) {
		try {
			$this->aQuery = "SELECT ID FROM Squid WHERE Activo = 1";
			$this->aParameters = array();
			$lResultados = $this->select();
			
			$lSquidID = 0;
			if ($lResultados) {
				$lSquidID = $lResultados[0]["ID"];
			}
			
			$this->aQuery = "SELECT * FROM ReglaPredefinidaIptablesXReglaPredefinidaSquid WHERE ReglaPredefinidaIptablesID = ?";
			$this->aParameters = array($pReglaIptablesID);
			$lResultados  = $this->select();
			foreach ($lResultados as $lResultado) {
				$lReglaID = $lResultado['ReglaPredefinidaSquidID'];
				$this->aQuery = "SELECT COUNT(*) 'Contador' FROM SquidxReglaPredefinida WHERE ReglaPredefinidaID = ? AND SquidID = ?";
				$this->aParameters = array($lReglaID, $lSquidID);
				$lResultados = $this->select();
				
				if ($lResultados[0]["Contador"] == 0) {
					$this->aQuery = "INSERT INTO SquidxReglaPredefinida (SquidID, ReglaPredefinidaID) VALUES (?,?)";
					$this->aParameters = array($lSquidID, $lReglaID);
					$this->insert();
				}
			}
			
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( $pSquidID ) {
		try {
			$this->aQuery = "DELETE FROM SquidxReglaPredefinida WHERE SquidID = ? AND ReglaPredefinidaID = ?";
			$this->aParameters = array($pSquidID, $this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorSquid( $pSquidID ) {
		try {
			$this->aQuery = "DELETE FROM SquidxReglaPredefinida WHERE SquidID = ?";
			$this->aParameters = array($pSquidID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarSquid( $pSquidID ) {
		try {
			$this->aQuery = "SELECT R.* FROM ReglaPredefinida R LEFT JOIN SquidxReglaPredefinida S ON S.ReglaPredefinidaID = R.ID WHERE S.SquidID = ?";
			$this->aParameters = array($pSquidID);
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
	
	public function listarNoSquid( $pSquidID ) {
		try {
			$this->aQuery = "SELECT * FROM ReglaPredefinida WHERE ID NOT IN (SELECT ReglaPredefinidaID FROM SquidxReglaPredefinida WHERE SquidID = ?)";
			$this->aParameters = array($pSquidID);
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
