<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Protocolo/modelo/dao/DAOProtocolo.php
 * @class modulo/Protocolo/modelo/dao/DAOProtocolo.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Protocolo.php';

/**
 * class DAOProtocolo
 */
class DAOProtocolo extends DAO {
	/**
	 *
	 * @param modelo::clases::Protocolo pProtocolo 
	 * @return 
	 * @access public
	 */
	public function __construct( $pProtocolo = null ) {
		parent::__construct($pProtocolo, BASE_DATOS_IPTABLES);
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
			$this->aQuery = "SELECT * FROM Protocolo";
			$lResultados = $this->select();
	
			$lProtocolos = array();
			foreach ($lResultados as $lResultado) {
				$lProtocolos[] = $this->cargarObjeto($lResultado);
			}
			
			return $lProtocolos;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Protocolo WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Protocolo();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM Protocolo WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Protocolo();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lProtocolo = new Protocolo();
		$lProtocolo->ID = $pResultado['ID'];
		$lProtocolo->Nombre = $pResultado['Nombre'];
		$lProtocolo->Descripcion = $pResultado['Descripcion'];
		
		return $lProtocolo;
	}

} // end of DAOTabla
?>
