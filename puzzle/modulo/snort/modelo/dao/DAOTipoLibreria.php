<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOTipoLibreria.php
 * @class modulo/Snort/modelo/dao/DAOTipoLibreria.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."TipoLibreria.php";

/**
 * class DAOTipoLibreria
 */
class DAOTipoLibreria extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::TipoLibreria pTipoLibreria 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTipoLibreria = null ) {
		parent::__construct($pTipoLibreria, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM TipoLibreria WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lTipoLibreria = new TipoLibreria();
			if ($lResultado) {
				$lTipoLibreria = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoLibreria;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoLibreria WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultado = $this->select();
	
			$lTipoLibreria = new TipoLibreria();
			if ($lResultado) {
				$lTipoLibreria = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoLibreria;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listar( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoLibreria";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lTiposLibreria = array();
			foreach ($lResultados as $lResultado) {
				$lTiposLibreria[] = $this->cargarObjeto($lResultado);
			}
		
			return $lTiposLibreria;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lTipoLibreria = new TipoLibreria();
		$lTipoLibreria->ID = $pResultado['ID'];
		$lTipoLibreria->Nombre = $pResultado['Nombre'];
		$lTipoLibreria->Descripcion = $pResultado['Descripcion'];
		
		return $lTipoLibreria;
	}

} // end of DAOTipoLibreria
?>
