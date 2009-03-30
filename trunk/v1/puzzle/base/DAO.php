<?php

abstract class DAO {
	
	protected $aObjeto = null;
	protected $aQuery = "";
	protected $aParameters = array();
	protected $aBaseDatos = "";
	protected $aConexion = "";
	protected $aError = "";
	
	/**
	 * Constructor de la clase
	 *
	 * @param string pNombre Nombre de la base de datos a la cual se conectará la aplicación
	 * @return 
	 * @static
	 * @access private
	*/
	protected function __construct($pObjeto, $pNombre = BASE_DATOS ) {
		$this->aObjeto = $pObjeto;
		$this->aBaseDatos = $pNombre;
		$this->aParameters = array();
		$this->aConexion = new PDO('sqlite:'.$this->aBaseDatos,0666,$this->aError);
	} // end of member function __construct
	
	protected function __destruct() {
		unset($this->aConexion);
	}
	
	/**
	 *
	 * @param string lQuery 
	 * @return array
	 * @access public
	 */
	protected function select( ) {
		try {
			$lStmt = $this->aConexion->prepare($this->aQuery);
			if (!$lStmt) {
				print_r($this->aConexion->errorInfo());
			}
			if ($lStmt->execute($this->aParameters)) {
				$lResultado = $lStmt->fetchAll();
				return $lResultado;
			} else {
				throw new Exception("Select Error!!! ".$this->aQuery);
			}
		} catch (PDOException $e) {
			throw new Exception($e->getMessage);
		}
	} // end of member function select

	/**
	 *
	 * @param string lQuery 
	 * @return bool
	 * @access public
	 */
	protected function update( ) {
		try {
			$lStmt = $this->aConexion->prepare($this->aQuery);
			if (!$lStmt) {
				print_r($this->aConexion->errorInfo());
			}
			if ( $lStmt->execute($this->aParameters) ) {
				return true;
			} else {
				throw new Exception("Update Error!!! ".$this->aQuery);
			}
		} catch (PDOException $e) {
			throw new Exception($e->getMessage);
		}
	} // end of member function update

	/**
	 *
	 * @param string lQuery 
	 * @return bool
	 * @access public
	 */
	protected function insert(  ) {
		try {
			$lStmt = $this->aConexion->prepare($this->aQuery);
			if (!$lStmt) {
				print_r($this->aConexion->errorInfo());
			}
			if ( $lStmt->execute($this->aParameters) ) {
				return true;
			} else {
				throw new Exception("Insert Error!!! ".$this->aQuery);
			}
		} catch (PDOException $e) {
			throw new Exception($e->getMessage);
		}
	} // end of member function insert

	/**
	 *
	 * @param string lQuery 
	 * @return bool
	 * @access public
	 */
	protected function delete(  ) {
		try {
			$lStmt = $this->aConexion->prepare($this->aQuery);
			if (!$lStmt) {
				print_r($this->aConexion->errorInfo());
			}
			if ($lStmt->execute($this->aParameters)) {
			} else {
				throw new Exception("Delete Error!!! ".$this->aQuery);
			}
			return true;
		} catch (PDOException $e) {
			throw new Exception($e->getMessage);
		}
	} // end of member function delete
}

?>