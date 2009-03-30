<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOParametro.php
 * @class modulo/Snort/modelo/dao/DAOParametro.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."Parametro.php";

/**
 * class DAOParametro
 */
class DAOParametro extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Parametro pParametro 
	 * @return 
	 * @access public
	 */
	public function __construct( $pParametro = null ) {
		parent::__construct($pParametro, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM Parametro WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lParametro = new Parametro();
			if ($lResultado) {
				$lParametro = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lParametro;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function buscarTipoPreprocesador( $pTipoPreprocesadorID ) {
		try {
			$this->aQuery = "SELECT * FROM Parametro WHERE TipoPreprocesadorID = ?";
			$this->aParameters = array($pTipoPreprocesadorID);
			$lResultados = $this->select();
	
			$lParametros = array();
			foreach ($lResultados as $lResultado) {
				$lParametros[] = $this->cargarObjeto($lResultado);
			}
		
			return $lParametros;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarPreprocesador( $pPreprocesadorID ) {
		try {
			$this->aQuery = "SELECT P.*, PxP.Valor 'Valor' FROM Parametro P LEFT JOIN ParametroxPreprocesador PxP ON (P.ID = PxP.ParametroID) WHERE PxP.PreprocesadorID = ?";
			$this->aParameters = array($pPreprocesadorID);
			$lResultados = $this->select();
	
			$lParametros = array();
			foreach ($lResultados as $lResultado) {
				$lParametros[] = $this->cargarObjeto($lResultado);
			}
		
			return $lParametros;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lParametro = new Parametro();
		$lParametro->ID = $pResultado['ID'];
		$lParametro->Nombre = $pResultado['Nombre'];
		$lParametro->Descripcion = $pResultado['Descripcion'];
		if (isset($pResultado['Valor'])) {
			$lParametro->Valor = $pResultado['Valor'];
		}
		
		return $lParametro;
	}

} // end of DAOParametro
?>
