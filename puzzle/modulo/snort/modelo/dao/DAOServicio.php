<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Snort/modelo/dao/DAOServicio.php
 * @class modulo/Snort/modelo/dao/DAOServicio.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'DAO.php';
require_once CLASES_SNORT."Servicio.php";
require_once DAO_SNORT."DAOTipoServicio.php";
require_once DAO."DAONodo.php";

/**
 * class DAOServicio
 */
class DAOServicio extends DAO {
	
	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Servicio pServicio 
	 * @return 
	 * @access public
	 */
	public function __construct( $pServicio = null ) {
		parent::__construct($pServicio, BASE_DATOS_SNORT);
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
			$this->aQuery = "SELECT * FROM Servicio WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
	
			$lServicio = new Servicio();
			if ($lResultado) {
				$lServicio = $this->cargarObjeto($lResultado[0]);
				$lServicio->Nodos = $this->cargarNodos($lServicio->ID);
			}
		
			return $lServicio;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
	
	public function listarSnort( $pSnortID ) {
		try {
			$this->aQuery = "SELECT * FROM Servicio WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			$lResultados = $this->select();
			$lServicios = array();
			foreach ($lResultados as $lResultado) {
				$lServicio = $this->cargarObjeto($lResultado);
				$lServicio->Nodos = $this->cargarNodos($lServicio->ID);
				$lServicios[] = $lServicio;
			}
			
			return $lServicios;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarNodos( $pServicioID ) {
		try {
			$this->aQuery = "SELECT * FROM NodoxServicio WHERE ServicioID = ?";
			$this->aParameters = array($pServicioID);
			$lResultados = $this->select();
			
			$lNodos = array();
			foreach ($lResultados as $lResultado) {
				$lNodo = new Nodo();
				$lNodo->ID = $lResultado['NodoID'];
				$lDAONodo = new DAONodo($lNodo);
				$lNodo = $lDAONodo->buscarID();
				$lNodos[] = $lNodo;
			}
			return $lNodos;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function insertar( $pSnortID ) {
		try {
			$this->aQuery = "INSERT INTO Servicio (SnortID, TipoServicioID, Puertos) VALUES (?,?,?)";
			$this->aParameters = array($pSnortID,  $this->aObjeto->TipoServicio->ID, $this->aObjeto->Puertos);
			if ($this->insert()) {
				$lServicio = $this->buscarMaxID();
				foreach ($this->aObjeto->Nodos as $lNodo) {
					$this->aQuery = "INSERT INTO NodoxServicio (NodoID, ServicioID) VALUES (?,?)";
					$this->aParameters = array($lNodo->ID,  $lServicio->ID);
					return $this->insert();
				}
			}
			return false;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID() {
		try {
			$this->aQuery = "SELECT * FROM Servicio WHERE ID = (SELECT MAX(ID) FROM Servicio)";
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
	
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM NodoxServicio WHERE ServicioID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			if ($this->delete()) {
				$this->aQuery = "DELETE FROM Servicio WHERE ID = ?";
				$this->aParameters = array($this->aObjeto->ID);
				return $this->delete();
			}
			return false;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function eliminarSnort( $pSnortID ) {
		try {
			$this->aQuery = "DELETE FROM NodoxServicio WHERE ServicioID  IN (SELECT ID FROM Servicio Where SnortID = ?)";
			$this->aParameters = array($pSnortID);
			$this->delete();
			
			$this->aQuery = "DELETE FROM Servicio WHERE SnortID = ?";
			$this->aParameters = array($pSnortID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto ($pResultado) {
		$lServicio = new Servicio();
		$lServicio->ID = $pResultado['ID'];
		$lServicio->Puertos = $pResultado['Puertos'];
		
		$lTipoServicio = new TipoServicio();
		$lTipoServicio->ID = $pResultado['TipoServicioID'];
		$lDAOTipoServicio = new DAOTipoServicio($lTipoServicio);
		$lServicio->TipoServicio = $lDAOTipoServicio->buscarID();

		return $lServicio;
	}

} // end of DAOServicio
?>
