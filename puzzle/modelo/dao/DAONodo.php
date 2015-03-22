<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAONodo.php
 * @class modelo/dao/DAONodo.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Nodo.php';
require_once BASE.'DAO.php';


/**
 * class DAONodo
 * Permite manejar la persistencia de un objeto Nodo.
 */
class DAONodo extends DAO {

	/**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Nodo pNodo Objeto de tipo Nodo

	 * @return 
	 * @access public
	 */
	public function __construct( $pNodo = null ) {
		parent::__construct($pNodo);
	} // end of member function __construct

	/**
	 * Destructor de la clase.
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		parent::__destruct();
	} // end of member function __destruct

	/**
	 * Permite agregar nuevos Nodos a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( $pSubredID ) {
		try {
			$this->aQuery = "INSERT INTO Nodo (SubredID,Hostname,IP) VALUES (?,?,?)";
			$this->aParameters = array($pSubredID, $this->aObjeto->Hostname, $this->aObjeto->IP);
			$lResultado = $this->insert();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregar

	/**
	 * Permite modificar valores registrados en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function modificar( $pSubredID ) {
		try {
			$this->aQuery = "UPDATE Nodo SET SubredID = ?,Hostname = ?, IP = ? WHERE ID = ?";
			$this->aParameters = array($pSubredID, $this->aObjeto->Hostname, $this->aObjeto->IP, $this->aObjeto->ID);
			$lResultado = $this->update();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function modificar

	/**
	 * Permite eliminar nodos registrados en la base de datos.
	 *
	 * @return 
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM Nodo WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->delete();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar
			
	/**
	 * Permite eliminar nodos registrados en la base de datos.
	 *
	 * @param int pInterfazId
	 * @return 
	 * @access public
	 */
	public function eliminarPorSubred( $pSubredID ) {
		try {
			$this->aQuery = "DELETE FROM Nodo WHERE SubredID = ?";
			$this->aParameters = array($pSubredID);
			$lResultado = $this->delete();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminarPorInterfaz
			
	/**
	 *
	 * @param int pSubredId
	 * @return array
	 * @access public
	 */
	public function listarPorSubred( $pSubredID ) {
		try {
			$this->aQuery = "SELECT * FROM Nodo WHERE SubredID = ?";
			$this->aParameters = array($pSubredID);
			$lResultados = $this->select();
	
			$lNodos = array();
			foreach ($lResultados as $lResultado) {
				$lNodos[] = $this->cargarObjeto($lResultado);
			}
			
			return $lNodos;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarPorServidor
			
	/**
	 * Permite buscar un nodo con un determinado IP.
	 *
	 * @return modelo::clases::Nodo
	 * @access public
	 */
	public function buscarPorIP( ) {
		try {
			$this->aQuery = "SELECT * FROM Nodo WHERE IP = ?";
			$this->aParameters = array($this->aObjeto->IP);
			$lResultados = $this->select();
	
			$lNodos = array();
			foreach ($lResultados as $lResultado) {
				$lNodos[] = $this->cargarObjeto($lResultado);
			}
			
			return $lNodos;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
			
	public function buscarSinSubred( ) {
		try {
			$this->aQuery = "SELECT N.ID,N.Hostname,N.IP FROM Nodo N LEFT JOIN Subred S ON (S.ID = N.SubredID) WHERE S.InterfazID NOT IN (SELECT I.ID From Interfaz I)";
			$lResultados = $this->select();
	
			$lNodos = array();
			foreach ($lResultados as $lResultado) {
				$lNodos[] = $this->cargarObjeto($lResultado);
			}
			
			return $lNodos;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarPorInterfaz($pInterfaz ) {
		try {
			$this->aQuery = "SELECT N.ID,N.Hostname,N.IP FROM Nodo N LEFT JOIN Subred S ON (N.SubredID = S.ID) LEFT JOIN Interfaz I ON (S.InterfazID = I.ID) Where I.ID = ?";
			$this->aParameters = array($pInterfaz);
			$lResultados = $this->select();
	
			$lNodos = array();
			foreach ($lResultados as $lResultado) {
				$lNodos[] = $this->cargarObjeto($lResultado);
			}
			
			return $lNodos;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Permite buscar un nodo con un determinado ID.
	 *
	 * @return modelo::clases::Nodo
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Nodo WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();
		
			$lNodo = new Nodo();
			if ($lResultado) {
				$lNodo = $this->cargarObjeto($lResultado[0]);
			}
			
			return $lNodo;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID

	protected function cargarObjeto($pResultado) {
		$lNodo = new Nodo();
		$lNodo->IP = $pResultado['IP'];
		$lNodo->ID = $pResultado['ID'];
		$lNodo->Hostname = $pResultado['Hostname'];

		return $lNodo;
	}
	
} // end of DAONodo
?>
