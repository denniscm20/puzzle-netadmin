<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOTipoACL.php
 * @class modulo/Squid/modelo/dao/DAOTipoACL.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."TipoACL.php";

/**
 * class DAOTipoACL
 */
class DAOTipoACL extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::TipoACL pTipoACL 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTipoACL = null ) {
		parent::__construct($pTipoACL, BASE_DATOS_SQUID);
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
			$this->aQuery = "SELECT * FROM TipoACL WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lTipoACL = new TipoACL();
			if ($lResultado) {
				$lTipoACL = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoACL;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoACL";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lTiposACL = array();
			foreach ($lResultados as $lResultado) {
				$lTiposACL[] = $this->cargarObjeto($lResultado);
			}
			
			return $lTiposACL;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lTipoACL = new TipoACL();
		$lTipoACL->ID = $pResultado['ID'];
		$lTipoACL->Nombre = $pResultado['Nombre'];
		$lTipoACL->Descripcion = $pResultado['Descripcion'];
		
		return $lTipoACL;
	}

} // end of DAOTipoACL
?>
