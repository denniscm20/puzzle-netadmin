<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOSubred.php
 * @class modelo/dao/DAOSubred.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Subred.php';
require_once DAO.'DAONodo.php';
require_once BASE.'DAO.php';


/**
 * class DAOSubred
 * Permite manejar la persistencia de un objeto Subred.
 */
class DAOSubred extends DAO {

	 /**
	 * Constructor de la clase
	 *
	 * @param modelo::clases::Subred pSubred 
	 * @return 
	 * @access public
	 */
	public function __construct( $pSubred = null ) {
		parent::__construct($pSubred);
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
	 * Permite agregar nuevas Subredes a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( $pInterfazID ) {
		try {
			$this->aQuery = "INSERT INTO Subred (InterfazID,Nombre,IP,Mascara,MascaraCorta) VALUES (?,?,?,?,?)";
			$this->aParameters = array($pInterfazID, $this->aObjeto->Nombre, $this->aObjeto->IP, $this->aObjeto->Mascara, $this->aObjeto->MascaraCorta);
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
	public function modificar( $pInterfazID ) {
		try {
			$this->aQuery = "UPDATE Subred SET InterfazID = ?,Nombre = ?, IP = ?,Mascara = ?, MascaraCorta = ? WHERE ID = ?";
			$this->aParameters = array($pInterfazID, $this->aObjeto->Nombre, $this->aObjeto->IP, $this->aObjeto->Mascara, $this->aObjeto->MascaraCorta,$this->aObjeto->ID);
			$lResultado = $this->update();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function modificar

	/**
	 * Permite eliminar subredes registradas en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM Subred WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->delete();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar
			
	public function recargarInterfaz( $pIP ) {
		try {
			$this->aQuery = "UPDATE Subred SET InterfazID = (SELECT B.ID FROM Interfaz B WHERE B.IP LIKE '".$pIP."%') WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->update();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Permite buscar todas las subredes que cumplan con el criterio de búsqueda.
	 *
	 * @return 
	 * @access public
	 */
	public function listarPorInterfaz( $pInterfazID ) {
		try {
			$this->aQuery = "SELECT * FROM Subred WHERE InterfazID = ?";
			$this->aParameters = array($pInterfazID);
			$lResultados = $this->select();
	
			$lSubredes = array();
			foreach ($lResultados as $lResultado) {
				$lSubredes[] = $this->cargarObjeto($lResultado);
			}
			
			return $lSubredes;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscar
			
	public function listarTodos( ) {
		try {
			$this->aQuery = "SELECT * FROM Subred";
			$lResultados = $this->select();
	
			$lSubredes = array();
			foreach ($lResultados as $lResultado) {
				$lSubredes[] = $this->cargarObjeto($lResultado);
			}
			
			return $lSubredes;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function listarSubredSinInterfaz( ) {
		try {
			$this->aQuery = "SELECT * FROM Subred WHERE InterfazID NOT IN (SELECT ID FROM Interfaz)";
			$lResultados = $this->select();
	
			$lSubredes = array();
			foreach ($lResultados as $lResultado) {
				$lSubredes[] = $this->cargarObjeto($lResultado);
			}
			
			return $lSubredes;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function buscarMaxID() {
		try {
			$this->aQuery = "SELECT * FROM Interfaz WHERE ID = (SELECT MAX(ID) FROM Interfaz)";
			$this->aParameters = array();
			$lResultados = $this->select();
	
			if ($lResultados) {
				return $this->cargarObjeto($lResultados[0]);
			}
			
			return new Squid();
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 *
	 * @return modelo::clases::Subred
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Subred WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();

			$lSubred = new Subred();
			if ($lResultado) {
				$lSubred = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lSubred;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
			
	/**
	 *
	 * @return modelo::clases::Subred
	 * @access public
	 */
	public function buscarPorNombreIP( ) {
		try {
			$this->aQuery = "SELECT * FROM Subred WHERE Nombre = ? AND IP = ?";
			$this->aParameters = array($this->aObjeto->Nombre, $this->aObjeto->IP);
			$lResultado = $this->select();

			$lSubred = new Subred();
			if ($lResultado) {
				$lSubred = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lSubred;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID

	protected function cargarObjeto($pElemento) {
		$lSubred = new Subred();
		$lSubred->ID = $pElemento['ID'];
		$lSubred->Nombre = $pElemento['Nombre'];
		$lSubred->IP = $pElemento['IP'];
		$lSubred->Mascara = $pElemento['Mascara'];
		$lSubred->MascaraCorta = $pElemento['MascaraCorta'];
		
		$lDAONodo = new DAONodo();
		$lSubred->Nodos = $lDAONodo->listarPorSubred($lSubred->ID);
		
		return $lSubred;
	}

} // end of DAOSubred
?>
