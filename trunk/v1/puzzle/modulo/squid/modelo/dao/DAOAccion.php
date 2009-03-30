<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Accion/modelo/dao/DAOAccion.php
 * @class modulo/Accion/modelo/dao/DAOAccion.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID.'Accion.php';

/**
 * class DAOAccion
 */
class DAOAccion extends DAO {

	/**
	 *
	 * @param modelo::clases::Accion pAccion 
	 * @return 
	 * @access public
	 */
	public function __construct( $pAccion = null ) {
		parent::__construct($pAccion, BASE_DATOS_SQUID);
	} // end of member function __construct

	public function __destruct() {
		parent::__destruct();
	}

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM Accion";
			$lResultados = $this->select();
	
			$lAcciones = array();
			foreach ($lResultados as $lResultado) {
				$lAcciones[] = $this->cargarObjeto($lResultado);
			}
			
			return $lAcciones;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Accion WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Accion();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM Accion WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Accion();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lAccion = new Accion();
		$lAccion->ID = $pResultado['ID'];
		$lAccion->Nombre = $pResultado['Nombre'];
		$lAccion->Descripcion = $pResultado['Descripcion'];
		
		return $lAccion;
	}

} // end of DAOAccion
?>
