<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOTipoPreprocesador.php
 * @class modulo/Snort/modelo/dao/DAOTipoPreprocesador.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."TipoPreprocesador.php";
require_once DAO_SNORT."DAOParametro.php";

/**
 * class DAOTipoPreprocesador
 */
class DAOTipoPreprocesador extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::TipoPreprocesador pTipoPreprocesador 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTipoPreprocesador = null ) {
		parent::__construct($pTipoPreprocesador, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM TipoPreprocesador WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lTipoPreprocesador = new TipoPreprocesador();
			if ($lResultado) {
				$lTipoPreprocesador = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoPreprocesador;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoPreprocesador WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultado = $this->select();
	
			$lTipoPreprocesador = new TipoPreprocesador();
			if ($lResultado) {
				$lTipoPreprocesador = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lTipoPreprocesador;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listar( ) {
		try {
			$this->aQuery = "SELECT * FROM TipoPreprocesador";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lTipoPreprocesadores = array();
			foreach ($lResultados as $lResultado) {
				$lTipoPreprocesadores[] = $this->cargarObjeto($lResultado);
			}
		
			return $lTipoPreprocesadores;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lTipoPreprocesador = new TipoPreprocesador();
		$lTipoPreprocesador->ID = $pResultado['ID'];
		$lTipoPreprocesador->Nombre = $pResultado['Nombre'];
		$lTipoPreprocesador->Descripcion = $pResultado['Descripcion'];
		
		$lDAOParametro = new DAOParametro();
		$lTipoPreprocesador->Parametros = $lDAOParametro->buscarTipoPreprocesador($lTipoPreprocesador->ID);
		return $lTipoPreprocesador;
	}

} // end of DAOTipoPreprocesador
?>
