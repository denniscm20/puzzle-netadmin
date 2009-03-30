<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Cadena/modelo/dao/DAOCadena.php
 * @class modulo/Cadena/modelo/dao/DAOCadena.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once DAO_IPTABLES.'DAOPolitica.php';
require_once DAO_IPTABLES.'DAOReglaIptables.php';
require_once CLASES_IPTABLES.'Cadena.php';

/**
 * class DAOCadena
 */
class DAOCadena extends DAO {
	/**
	 *
	 * @param modelo::clases::Cadena pCadena 
	 * @return 
	 * @access public
	 */
	public function __construct( $pCadena = null ) {
		parent::__construct($pCadena, BASE_DATOS_IPTABLES);
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
			$this->aQuery = "SELECT * FROM 'Cadena'";
			$lResultados = $this->select();
	
			$lCadenas = array();
			foreach ($lResultados as $lResultado) {
				$lCadenas[] = $this->cargarObjeto($lResultado);
			}
			
			return $lCadenas;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function listarPorTable($pTableID, $pIptablesID = 0) {
		try {
			$this->aQuery = "SELECT * FROM 'Cadena' WHERE TableID = ?";
			$this->aParameters = array($pTableID);
			$lResultados = $this->select();
	
			$lCadenas = array();
			foreach ($lResultados as $lResultado) {
				$lCadenas[] = $this->cargarObjeto($lResultado, $pTableID ,$pIptablesID);
			}
			
			return $lCadenas;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function actualizarPoliticas($pIptablesID, $pPoliticaID) {
		try {
			$this->aQuery = "UPDATE IptablesXCadenaXPolitica SET PoliticaID = ? WHERE IptablesID = ? AND CadenaID = ? ";
			$this->aParameters = array($pPoliticaID, $pIptablesID, $this->aObjeto->ID);
			return $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Cadena' WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Cadena();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarPorNombreTable( $pTableID ) {
		try {
			$this->aQuery = "SELECT * FROM 'Cadena' WHERE Nombre = ? and TableID = ?";
			$this->aParameters = array($this->aObjeto->Nombre,$pTableID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0], $pTableID);
			}
			
			return new Cadena();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado, $pTableID = 0, $pIptablesID = 0) {
		$lCadena = new Cadena();
		$lCadena->ID = $pResultado['ID'];
		$lCadena->Nombre = $pResultado['Nombre'];
		$lCadena->Descripcion = $pResultado['Descripcion'];
		
		$lDAOPolitica = new DAOPolitica();
		$lCadena->Politica = $lDAOPolitica->buscarPorIptablesCadena($pIptablesID, $lCadena->ID);
		
		$lDAOReglaIptables = new DAOReglaIptables();
		$lCadena->ReglasIptables = $lDAOReglaIptables->listarPorIptablesTablaCadena($pIptablesID, $pTableID, $lCadena->ID);
		
		return $lCadena;
	}

} // end of DAOTabla
?>

