<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOPreprocesador.php
 * @class modulo/Snort/modelo/dao/DAOPreprocesador.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."Preprocesador.php";
require_once DAO_SNORT."DAOTipoPreprocesador.php";
require_once DAO_SNORT."DAOParametro.php";

/**
 * class DAOPreprocesador
 */
class DAOPreprocesador extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Preprocesador pPreprocesador 
	 * @return 
	 * @access public
	 */
	public function __construct( $pPreprocesador = null ) {
		parent::__construct($pPreprocesador, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM Preprocesador WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lPreprocesador = new Preprocesador();
			if ($lResultado) {
				$lPreprocesador = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lPreprocesador;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function listarSnort( $pSnortID ) {
		try {
			$this->aQuery = "SELECT * FROM Preprocesador WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
	
			$lPreprocesadores = array();
			foreach ($lResultados as $lResultado) {
				$lPreprocesadores[] = $this->cargarObjeto($lResultado);
			}
		
			return $lPreprocesadores;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function insertar( $pSnortID ) {
		try {
			$this->aQuery = "INSERT INTO Preprocesador (SnortID, TipoPreprocesadorID) VALUES (?,?)";
			$this->aParameters = array($pSnortID,  $this->aObjeto->TipoPreprocesador->ID);
			$this->insert();
	
			$lPreprocesador = $this->buscarMaxID();
			$this->aQuery = "INSERT INTO ParametroxPreprocesador (PreprocesadorID, ParametroID, Valor) VALUES (?, ?, ?)";
			foreach ($this->aObjeto->Parametros as $lParametro) {
				$this->aParameters = array($lPreprocesador->ID, $lParametro->ID, $lParametro->Valor);
				$this->insert();
			}
			
			return true;
		
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID() {
		try {
			$this->aQuery = "SELECT * FROM Preprocesador WHERE ID = (SELECT MAX(ID) FROM Preprocesador)";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Preprocesador();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM Preprocesador WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarSnort( $pSnortID ) {
		try {
			$this->aQuery = "DELETE FROM ParametroxPreprocesador WHERE PreprocesadorID  IN (SELECT ID FROM Preprocesador Where SnortID = ?)";
			$this->aParameters = array($pSnortID);
			$this->delete();
			
			$this->aQuery = "DELETE FROM Preprocesador WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lPreprocesador = new Preprocesador();
		$lPreprocesador->ID = $pResultado['ID'];
		
		$lTipoPreprocesador = new TipoPreprocesador();
		$lTipoPreprocesador->ID = $pResultado['TipoPreprocesadorID'];
		$lDAOTipoPreprocesador = new DAOTipoPreprocesador($lTipoPreprocesador);
		$lPreprocesador->TipoPreprocesador = $lDAOTipoPreprocesador->buscarID();
		
		$lDAOParametro = new DAOParametro();
		$lPreprocesador->Parametros = $lDAOParametro->buscarPreprocesador($lPreprocesador->ID);
		
		return $lPreprocesador;
	}

} // end of DAOPreprocesador
?>
