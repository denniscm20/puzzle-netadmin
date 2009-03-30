<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/dao/DAODetalleReglaPredefinida.php
 * @class modulo/Iptables/modelo/dao/DAODetalleReglaPredefinida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once DAO_IPTABLES.'DAOAccion.php';
require_once DAO_IPTABLES.'DAOEstado.php';
require_once DAO_IPTABLES.'DAOProtocolo.php';
require_once CLASES_IPTABLES.'DetalleReglaPredefinida.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once CLASES_IPTABLES.'Estado.php';
require_once CLASES_IPTABLES.'Protocolo.php';

/**
 * class DAODetalleReglaPredefinida
 */
class DAODetalleReglaPredefinida extends DAO {

	/**
	 *
	 * @param modelo::clases::ReglaTable pReglaTable 
	 * @return 
	 * @access public
	 */
	public function __construct( $pReglaTable = null ) {
		parent::__construct($pReglaTable, BASE_DATOS_IPTABLES);
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
	public function listarPorReglaPredefinida( $pReglaPredefinidaID ) {
		try {
			$this->aQuery = "SELECT * FROM DetalleReglaPredefinida WHERE ReglaPredefinidaID = ? ";
			$this->aParameters = array($pReglaPredefinidaID);
			$lResultados = $this->select();
	
			$lDetalleReglaPredefinida = array();
			foreach ($lResultados as $lResultado) {
				$lDetalleReglaPredefinida[] = $this->cargarObjeto($lResultado);
			}
			
			return $lDetalleReglaPredefinida;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos

	protected function cargarObjeto($pResultado) {
		$lDetalleReglaPredefinida = new DetalleReglaPredefinida();
		$lDetalleReglaPredefinida->ID = $pResultado['ID'];
		$lDetalleReglaPredefinida->Regla = $pResultado['Regla'];
		
		return $lDetalleReglaPredefinida;
	}


} // end of DAODetalleReglaPredefinida
?>