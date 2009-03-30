<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOIPv4Valida.php
 * @class modelo/dao/DAOIPv4Valida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES.'IPv4Valida.php';

/**
 * class DAOIPv4Valida
 * Maneja la persistencia de las direcciones IP permitidas.
 */
class DAOIPv4Valida extends DAO {

	/**
	 *
	 * @param modelo::clases::IPv4Valida pIPv4Valida 
	 * @return 
	 * @access public
	 */
	public function __construct( $pIPv4Valida = null ) {
		parent::__construct($pIPv4Valida);
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
	 * @return bool
	 * @access public
	 */
	public function agregar( $pServidorID ) {
		try {
			$this->aQuery = "INSERT INTO IPv4Valida (ServidorID,IP) VALUES (?,?)";
			$this->aParameters = array($pServidorID, $this->aObjeto->IP);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregar

	/**
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM IPv4Valida WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarPorServidor( $pServidorID ) {
		try {
			$this->aQuery = "SELECT * FROM IPv4Valida WHERE ServidorID = ?";
			$this->aParameters = array($pServidorID);
			$lResultados = $this->select();
	
			$lIPv4Validas = array();
			foreach ($lResultados as $lResultado) {
				$lIPv4Validas[] = $this->cargarObjeto($lResultado);
			}
			
			return $lIPv4Validas;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	/**
	 *
	 * @param int pIP
	 * @return array
	 * @access public
	 */
	public function buscarPorIP( $pIP ) {
		try {
			$this->aQuery = "SELECT * FROM IPv4Valida WHERE IP = ?";
			$this->aParameters = array($pIP);
			$lResultados = $this->select();
			$lIPv4Validas = array();
			
			foreach ($lResultados as $lResultado) {
				$lIPv4Validas[] = $this->cargarObjeto($lResultado);
			}
			
			return $lIPv4Validas;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
			
	protected function cargarObjeto($pResultado) {
		$lIPv4Valida = new IPv4Valida($pResultado['IP']);
		$lIPv4Valida->ID = $pResultado['ID'];
		
		return $lIPv4Valida;
	}

} // end of DAOIPv4Valida
?>
