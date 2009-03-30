<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Politica/modelo/dao/DAOPolitica.php
 * @class modulo/Politica/modelo/dao/DAOPolitica.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Politica.php';

/**
 * class DAOPolitica
 */
class DAOPolitica extends DAO {
	/**
	 *
	 * @param modelo::clases::Politica pPolitica 
	 * @return 
	 * @access public
	 */
	public function __construct( $pPolitica = null ) {
		parent::__construct($pPolitica, BASE_DATOS_IPTABLES);
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
	public function listarTodos( ) {
		try {
			$this->aQuery = sprintf("SELECT * FROM 'Politica'");
			$this->aParameters = array();
			$lResultados = $this->select();
	
			$lPoliticas = array();
			foreach ($lResultados as $lResultado) {
				$lPoliticas[] = $this->cargarObjeto($lResultado);
			}
			
			return $lPoliticas;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function buscarPorIptablesCadena( $pIptablesID, $pCadenaID ) {
		try {
			$this->aQuery = "SELECT P.* FROM Politica P LEFT JOIN IptablesXCadenaXPolitica I ON (P.ID = I.PoliticaID) LEFT JOIN Cadena C ON (C.ID = I.CadenaID) WHERE I.IptablesID = ? AND C.ID = ?";
			$this->aParameters = array($pIptablesID, $pCadenaID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Politica();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarPorIptables
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Politica' WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Politica();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Politica' WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Politica();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lPolitica = new Politica();
		$lPolitica->ID = $pResultado['ID'];
		$lPolitica->Nombre = $pResultado['Nombre'];
		$lPolitica->Descripcion = $pResultado['Descripcion'];
		
		return $lPolitica;
	}

} // end of DAOTabla
?>
