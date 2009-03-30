<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOTipoAcceso.php
 * @class modulo/Squid/modelo/dao/DAOTipoAcceso.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."TipoAcceso.php";

/**
 * class DAOTipoAcceso
 */
class DAOTipoAcceso extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::TipoAcceso pTipoAcceso 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTipoAcceso = null ) {
		parent::__construct($pTipoAcceso, BASE_DATOS_SQUID);
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
			$this->aQuery = "SELECT * FROM TipoAcceso WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lTipoAcceso = new TipoAcceso();
			if ($lResultado) {
				$lTipoAcceso = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoAcceso;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoAcceso WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultado = $this->select();
	
			$lTipoAcceso = new TipoAcceso();
			if ($lResultado) {
				$lTipoAcceso = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoAcceso;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lTipoAcceso = new TipoAcceso();
		$lTipoAcceso->ID = $pResultado['ID'];
		$lTipoAcceso->Nombre = $pResultado['Nombre'];
		$lTipoAcceso->Descripcion = $pResultado['Descripcion'];
		
		return $lTipoAcceso;
	}

} // end of DAOTipoAcceso
?>
