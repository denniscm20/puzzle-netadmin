<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOLibreria.php
 * @class modulo/Snort/modelo/dao/DAOLibreria.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."Libreria.php";
require_once CLASES_SNORT."TipoLibreria.php";
require_once CLASES_SNORT."TipoValor.php";
require_once DAO_SNORT."DAOTipoLibreria.php";
require_once DAO_SNORT."DAOTipoValor.php";

/**
 * class DAOLibreria
 */
class DAOLibreria extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Libreria pLibreria 
	 * @return 
	 * @access public
	 */
	public function __construct( $pLibreria = null ) {
		parent::__construct($pLibreria, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM Libreria WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lLibreria = new Libreria();
			if ($lResultado) {
				$lLibreria = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lLibreria;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function listarSnort( $pSnortID ) {
		try {
			$this->aQuery = "SELECT * FROM Libreria WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
	
			$lLibrerias = array();
			foreach ($lResultados as $lResultado) {
				$lLibreria = $this->cargarObjeto($lResultado);
				$lLibrerias[] = $lLibreria;
			}
		
			return $lLibrerias;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function insertar( $pSnortID ) {
		try {
			$this->aQuery = "INSERT INTO Libreria (SnortID, TipoLibreriaID, TipoValorID, Valor) VALUES (?,?,?,?)";
			$this->aParameters = array($pSnortID,  $this->aObjeto->TipoLibreria->ID,  $this->aObjeto->TipoValor->ID,  $this->aObjeto->Valor);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM Libreria WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarSnort( $pSnortID ) {
		try {
			$this->aQuery = "DELETE FROM Libreria WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lLibreria = new Libreria();
		$lLibreria->ID = $pResultado['ID'];
		
		$lTipoLibreria = new TipoLibreria();
		$lTipoLibreria->ID = $pResultado['TipoLibreriaID'];
		$lDAOTipoLibreria = new DAOTipoLibreria($lTipoLibreria);
		$lLibreria->TipoLibreria = $lDAOTipoLibreria->buscarID();
		
		$lTipoValor = new TipoValor();
		$lTipoValor->ID = $pResultado['TipoValorID'];
		$lDAOTipoValor = new DAOTipoValor($lTipoValor);
		$lLibreria->TipoValor = $lDAOTipoValor->buscarID();
		
		$lLibreria->Valor = $pResultado['Valor'];
		
		return $lLibreria;
	}

} // end of DAOLibreria
?>
