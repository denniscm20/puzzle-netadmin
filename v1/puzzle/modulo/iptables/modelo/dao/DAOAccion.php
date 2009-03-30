<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Accion/modelo/dao/DAOAccion.php
 * @class modulo/Accion/modelo/dao/DAOAccion.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Accion.php';

/**
 * class DAOAccion
 */
class DAOAccionIptables extends DAO {
	/**
	 *
	 * @param modelo::clases::Accion pAccion 
	 * @return 
	 * @access public
	 */
	public function __construct( $pAccion = null ) {
		parent::__construct($pAccion, BASE_DATOS_IPTABLES);
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
	public function listarPorTable( $pTableID ) {
		try {
			$this->aQuery = "SELECT * FROM Accion Where TableID = ?";
			$this->aParameters = array($pTableID);
			$lResultados = $this->select();
	
			$lAccions = array();
			foreach ($lResultados as $lResultado) {
				$lAccions[] = $this->cargarObjeto($lResultado);
			}
			
			return $lAccions;
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
			
			return new AccionIptables();
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
			
			return new AccionIptables();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lAccion = new AccionIptables();
		$lAccion->ID = $pResultado['ID'];
		$lAccion->Nombre = $pResultado['Nombre'];
		$lAccion->Descripcion = $pResultado['Descripcion'];
		
		return $lAccion;
	}

} // end of DAOAccion
?>
