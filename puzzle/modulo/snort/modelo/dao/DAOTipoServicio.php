<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOTipoServicio.php
 * @class modulo/Snort/modelo/dao/DAOTipoServicio.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."TipoServicio.php";

/**
 * class DAOTipoServicio
 */
class DAOTipoServicio extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::TipoServicio pTipoServicio 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTipoServicio = null ) {
		parent::__construct($pTipoServicio, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM TipoServicio WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lTipoServicio = new TipoServicio();
			if ($lResultado) {
				$lTipoServicio = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoServicio;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoServicio WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultado = $this->select();
	
			$lTipoServicio = new TipoServicio();
			if ($lResultado) {
				$lTipoServicio = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoServicio;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listar( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoServicio";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lTipoServicios = array();
			foreach ($lResultados as $lResultado) {
				$lTipoServicios[] = $this->cargarObjeto($lResultado);
			}
		
			return $lTipoServicios;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lTipoServicio = new TipoServicio();
		$lTipoServicio->ID = $pResultado['ID'];
		$lTipoServicio->Nombre = $pResultado['Nombre'];
		$lTipoServicio->Descripcion = $pResultado['Descripcion'];
		
		return $lTipoServicio;
	}

} // end of DAOTipoServicio
?>
