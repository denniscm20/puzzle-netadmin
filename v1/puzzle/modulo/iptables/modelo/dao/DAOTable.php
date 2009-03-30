<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Table/modelo/dao/DAOTable.php
 * @class modulo/Table/modelo/dao/DAOTable.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Table.php';
require_once DAO_IPTABLES.'DAOCadena.php';

/**
 * class DAOTable
 */
class DAOTable extends DAO {
	/**
	 *
	 * @param modelo::clases::Table pTable 
	 * @return 
	 * @access public
	 */
	public function __construct( $pTable = null ) {
		parent::__construct($pTable, BASE_DATOS_IPTABLES);
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
	public function listarTodos( $pIptablesID = 0 ) {
		try {
			$this->aQuery = "SELECT * FROM 'Table'";
			$lResultados = $this->select();
	
			$lTables = array();
			foreach ($lResultados as $lResultado) {
				$lTables[] = $this->cargarObjeto($lResultado, $pIptablesID);
			}
			
			return $lTables;
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
	public function listarPorNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Table' Where Nombre LIKE ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultados = $this->select();

			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Table();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM 'Table' WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Table();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado, $pIptablesID = 0) {
		$lTable = new Table();
		$lTable->ID = $pResultado['ID'];
		$lTable->Nombre = $pResultado['Nombre'];
		$lTable->Descripcion = $pResultado['Descripcion'];
		
		$lDAOCadena = new DAOCadena();
		$lTable->Cadenas = $lDAOCadena->listarPorTable($lTable->ID, $pIptablesID);
		
		return $lTable;
	}

} // end of DAOTabla
?>
