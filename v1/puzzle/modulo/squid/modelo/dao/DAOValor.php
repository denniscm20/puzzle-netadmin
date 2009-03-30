<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Squid/modelo/dao/DAOValor.php
 * @class modulo/Squid/modelo/dao/DAOValor.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SQUID."Valor.php";

/**
 * class DAOValor
 */
class DAOValor extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Valor pValor 
	 * @return 
	 * @access public
	 */
	public function __construct( $pValor = null ) {
		parent::__construct($pValor, BASE_DATOS_SQUID);
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
			$this->aQuery = "SELECT * FROM Valor WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lValor = new Valor();
			if ($lResultado) {
				$lValor = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lValor;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function listarACL( $pACLID ) {
		try {
			$this->aQuery = "SELECT * FROM Valor WHERE ListaControlAccesoID = ?";
			$this->aParameters = array($pACLID);
			$lResultados = $this->select();
	
			$lValores = array();
			foreach ($lResultados as $lResultado) {
				$lValores[] = $this->cargarObjeto($lResultado);
			}
			
			return $lValores;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function agregar($pListaControlAccesoID) {
		try {
			$this->aQuery = "INSERT INTO Valor (ListaControlAccesoID, Nombre) VALUES (?, ?)";
			$this->aParameters = array($pListaControlAccesoID, $this->aObjeto->Nombre);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarPorListaControlAcceso($pListaControlAccesoID) {
		try {
			$this->aQuery = "DELETE FROM Valor WHERE ListaControlAccesoID = ?";
			$this->aParameters = array($pListaControlAccesoID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto ($pResultado) {
		$lValor = new Valor();
		$lValor->ID = $pResultado['ID'];
		$lValor->Nombre = $pResultado['Nombre'];
		
		return $lValor;
	}

} // end of DAOValor
?>
