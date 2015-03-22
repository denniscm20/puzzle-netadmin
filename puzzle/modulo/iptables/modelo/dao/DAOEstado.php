<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOEstado.php
 * @class modelo/dao/DAOEstado.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Estado.php';

/**
 * class DAOEstado
 */
class DAOEstado extends DAO {

	/**
	 *
	 * @param modelo::clases::Estado pEstado 
	 * @return 
	 * @access public
	 */
	public function __construct( $pEstado = null ) {
		parent::__construct($pEstado, BASE_DATOS_IPTABLES);
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
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Estado'";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lEstados = array();
			foreach ($lResultados as $lResultado) {
				$lEstados[] = $this->cargarObjeto($lResultado);
			}
			
			return $lEstados;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Estado' where ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			$lEstado = new Estado();
			if ($lResultados) {
				$lEstado = $this->cargarObjeto($lResultados[0]);
			}
			
			return $lEstado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
			
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Estado' where Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultados = $this->select();
	
			$lEstado = new Estado();
			if ($lResultados) {
				$lEstado = $this->cargarObjeto($lResultados[0]);
			}
			
			return $lEstado;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lEstado = new Estado();
		$lEstado->ID = $pResultado['ID'];
		$lEstado->Nombre = $pResultado['Nombre'];
		$lEstado->Descripcion = $pResultado['Descripcion'];
		
		return $lEstado;
	}

} // end of DAOEstado
?>
