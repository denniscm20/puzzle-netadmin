<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOCategoria.php
 * @class modelo/dao/DAOCategoria.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_IPTABLES.'Categoria.php';

/**
 * class DAOCategoria
 */
class DAOCategoria extends DAO {

	/**
	 *
	 * @param modelo::clases::Categoria pCategoria 
	 * @return 
	 * @access public
	 */
	public function __construct( $pCategoria = null ) {
		parent::__construct($pCategoria, BASE_DATOS_IPTABLES);
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
			$this->aQuery = "SELECT * FROM Categoria";
			$lResultados = $this->select();
	
			$lCategorias = array();
			foreach ($lResultados as $lResultado) {
				$lCategorias[] = $this->cargarObjeto($lResultado);
			}
			
			return $lCategorias;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function listarPorIptables( $pIptablesID) {
		try {
			$this->aQuery = "SELECT DISTINCT(C.ID) ID, C.Nombre Nombre FROM Categoria C LEFT JOIN ReglaPredefinida R ON (R.CategoriaID = C.ID) LEFT JOIN IptablesXReglaPredefinidaXAccion A ON (A.ReglaPredefinidaID = R.ID) WHERE A.IptablesID = ?";
			$this->aParameters = array($pIptablesID);
			$lResultados = $this->select();
	
			$lCategorias = array();
			foreach ($lResultados as $lResultado) {
				$lCategorias[] = $this->cargarObjeto($lResultado);;
			}
			
			return $lCategorias;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	 *
	 * @return modelo::clases::Categoria
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Categoria WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();

			$lCategoria = new Categoria();
			if ($lResultados) {
				$lCategoria = $this->cargarObjeto($lResultados[0]);
			}
		
			return $lCategoria;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
	
	protected function cargarObjeto($pResultado) {
		$lCategoria = new Categoria();
		$lCategoria->ID = $pResultado['ID'];
		$lCategoria->Nombre = $pResultado['Nombre'];
		
		$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables();
		$lCategoria->ReglasPredefinidas = $lDAOReglaPredefinida->listarPorCategoria($lCategoria->ID);
		
		return $lCategoria;
	}

} // end of DAOCategoria
?>
