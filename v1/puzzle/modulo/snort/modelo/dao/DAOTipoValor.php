<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOTipoValor.php
 * @class modulo/Snort/modelo/dao/DAOTipoValor.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."TipoValor.php";

/**
 * class DAOTipoValor
 */
class DAOTipoValor extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::TipoValor pTipoValor 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTipoValor = null ) {
		parent::__construct($pTipoValor, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM TipoValor WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lTipoValor = new TipoValor();
			if ($lResultado) {
				$lTipoValor = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoValor;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoValor WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultado = $this->select();
	
			$lTipoValor = new TipoValor();
			if ($lResultado) {
				$lTipoValor = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoValor;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listar( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoValor";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lTipoValores = array();
			foreach ($lResultados as $lResultado) {
				$lTipoValores[] = $this->cargarObjeto($lResultado);
			}
		
			return $lTipoValores;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lTipoValor = new TipoValor();
		$lTipoValor->ID = $pResultado['ID'];
		$lTipoValor->Nombre = $pResultado['Nombre'];
		$lTipoValor->Descripcion = $pResultado['Descripcion'];
		
		return $lTipoValor;
	}

} // end of DAOTipoValor
?>
