<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOSnort.php
 * @class modulo/Snort/modelo/dao/DAOSnort.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT.'Snort.php';
require_once DAO_SNORT.'DAOReglaPredefinida.php';
require_once DAO_SNORT.'DAOServicio.php';
require_once DAO_SNORT.'DAOPreprocesador.php';
require_once DAO_SNORT.'DAOLibreria.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Interfaz.php';

/**
 * class DAOSnort
 */
class DAOSnort extends DAO {

	/**
	 *
	 * @param modelo::clases::Snort pSnort 
	 * @return 
	 * @access public
	 */
	public function __construct( $pSnort = null ) {
		parent::__construct($pSnort, BASE_DATOS_SNORT);
	} // end of member function __construct

	public function __destruct() {
		parent::__destruct();
	}

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM Snort";
			$lResultados = $this->select();
	
			$lSnorts = array();
			foreach ($lResultados as $lResultado) {
				$lSnorts[] = $this->cargarObjeto($lResultado);
			}
			
			return $lSnorts;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarTodos
	
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Snort WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Snort();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarActivo( ) {
		try {
			$this->aQuery = "SELECT * FROM Snort WHERE Activo = 1";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Snort();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function activar( ) {
		try {
			$this->aQuery = "UPDATE Snort SET Activo = 0";
			$this->aParameters = array();
			$this->update();
			
			$this->aQuery = "UPDATE Snort SET Activo = 1 WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID() {
		try {
			$this->aQuery = "SELECT * FROM Snort WHERE ID = (SELECT MAX(ID) FROM Snort)";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Snort();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function insertar() {
		try {
			$this->aQuery = "UPDATE Snort SET Activo = 0";
			$this->aParameters = array();
			$this->update();
			
			$this->aQuery = "INSERT INTO Snort (RutaReglas, RecursosLimitados, Activo) VALUES (?,?,1)";
			$this->aParameters = array($this->aObjeto->RutaReglas, $this->aObjeto->RecursosLimitados);
			$this->insert();
			
			$lSnort = $this->buscarMaxID();
			$this->aQuery = "INSERT INTO InterfazExternaxSnort (SnortID, InterfazID) VALUES (?,?)";
			foreach($this->aObjeto->InterfazExterna as $lInterfaz) {
				$this->aParameters = array($lSnort->ID, $lInterfaz->ID);
				$this->insert();
			}
			
			$this->aQuery = "INSERT INTO InterfazInternaxSnort (SnortID, InterfazID) VALUES (?,?)";
			foreach($this->aObjeto->InterfazInterna as $lInterfaz) {
				$this->aParameters = array($lSnort->ID, $lInterfaz->ID);
				$this->insert();
			}
			
			return true;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminar() {
		try {
			$this->aQuery = "DELETE FROM InterfazExternaxSnort WHERE SnortID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$this->delete();
			
			$this->aQuery = "DELETE FROM InterfazInternaxSnort WHERE SnortID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$this->delete();
			
			$this->aQuery = "DELETE FROM Snort WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarInterfazInterna( $pSnortID ) {
		try {
			$this->aQuery = "SELECT InterfazID FROM InterfazInternaxSnort WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
	
			$lInterfaces = array();
			foreach ($lResultados as $lResultado) {
				$lInterfaz = new Interfaz();
				$lInterfaz->ID = $lResultado['InterfazID'];
				$lDAOInterfaz = new DAOInterfaz($lInterfaz);
				$lInterfaces[] = $lDAOInterfaz->buscarID();
			}
			
			return $lInterfaces;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarInterfazExterna( $pSnortID ) {
		try {
			$this->aQuery = "SELECT InterfazID FROM InterfazExternaxSnort WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
	
			$lInterfaces = array();
			foreach ($lResultados as $lResultado) {
				$lInterfaz = new Interfaz();
				$lInterfaz->ID = $lResultado['InterfazID'];
				$lDAOInterfaz = new DAOInterfaz($lInterfaz);
				$lInterfaces[] = $lDAOInterfaz->buscarID();
			}
			
			return $lInterfaces;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($pResultado) {
		$lSnort = new Snort();
		$lSnort->ID = $pResultado['ID'];
		$lSnort->RutaReglas = $pResultado['RutaReglas'];
		$lSnort->RecursosLimitados = $pResultado['RecursosLimitados'];
		$lSnort->InterfazInterna = $this->cargarInterfazInterna($lSnort->ID);
		$lSnort->InterfazExterna = $this->cargarInterfazExterna($lSnort->ID);
		$lSnort->Activo = $pResultado['Activo'];
		
		$lDAOReglaPredefinida = new DAOReglaPredefinida();
		$lSnort->ReglasPredefinida = $lDAOReglaPredefinida->listarSnort($lSnort->ID);
		
		$lDAOServicio = new DAOServicio();
		$lSnort->Servicios = $lDAOServicio->listarSnort($lSnort->ID);
		
		$lDAOPreprocesador = new DAOPreprocesador();
		$lSnort->Preprocesadores = $lDAOPreprocesador->listarSnort($lSnort->ID);
		
		$lDAOLibreria = new DAOLibreria();
		$lSnort->Librerias = $lDAOLibreria->listarSnort($lSnort->ID);
		
		return $lSnort;
	}

} // end of DAOSnort
?>
