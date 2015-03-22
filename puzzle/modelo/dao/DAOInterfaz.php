<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOInterfaz.php
 * @class modelo/dao/DAOInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Interfaz.php';
require_once DAO.'DAOSubred.php';
require_once BASE.'DAO.php';


/**
 * class DAOInterfaz
 * Permite manejar la persistencia de los objetos de tipo Interfaz.
 */
class DAOInterfaz extends DAO {

	/**
	 * Constructor de la Clase.
	 *
	 * @param modelo::clases::Interfaz pInterfaz Objeto de tipo Interfaz sobre el que se aplicará la persistencia.

	 * @return 
	 * @access public
	 */
	public function __construct( $pInterfaz = null ) {
		parent::__construct($pInterfaz);
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
	 * Permite insertar una nueva Interfaz a la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( $pServidorID ) {
		try {
			$this->aQuery = "INSERT INTO Interfaz (ServidorID,IP,MAC,Nombre,Descripcion,Internet,Mascara) VALUES (?,?,?,?,?,?,?)";
			$this->aParameters = array($pServidorID, $this->aObjeto->IP, $this->aObjeto->MAC, $this->aObjeto->Nombre, $this->aObjeto->Descripcion,$this->aObjeto->Internet,$this->aObjeto->Mascara);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregar

	/**
	 * Permite registrar los datos de una Interfaz previamente registrada en la base de
	 * datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function modificar( ) {
		try {
			$this->aQuery = "UPDATE Interfaz SET IP = ?, MAC = ?, Nombre = ?, Descripcion = ?, Internet = ?, Mascara = ? WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->IP, $this->aObjeto->MAC, $this->aObjeto->Nombre, $this->aObjeto->Descripcion, $this->aObjeto->Internet, $this->aObjeto->Mascara, $this->aObjeto->ID);
			return $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function modificar

	/**
	 * Permite eliminar un objeto registrado en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminarPorServidor( $pServidorID ) {
		try {
			$this->aQuery = "DELETE FROM Interfaz WHERE ServidorID = ?";
			$this->aParameters = array($pServidorID);
			return $this->delete();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminar

	/**
	 *
	 * @param int pServidorID
	 * @return array
	 * @access public
	 */
	public function listarPorServidor( $pServidorID ) {
		try {
			$this->aQuery = "SELECT * FROM Interfaz WHERE ServidorID = ?";
			$this->aParameters = array($pServidorID);
			$lResultados = $this->select();
	
			$lInterfaces = array();
			foreach ($lResultados as $lResultado) {
				$lInterfaces[] = $this->cargarObjeto($lResultado);
			}
			
			return $lInterfaces;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function listarPorServidor
			
	public function buscarPorSubred( $pSubredID ) {
		try {
			$this->aQuery = "SELECT I.ID, I.IP, I.MAC, I.Nombre, I.Descripcion, I.Internet FROM Interfaz I LEFT JOIN Subred S ON (I.ID = S.InterfazID) WHERE S.ID = ?";
			$this->aParameters = array($pSubredID);
			$lResultados = $this->select();
	
			$lInterfaz = new Interfaz();
			if ($lResultados) {
				$lInterfaz = $this->cargarObjeto($lResultados[0]);
			}
			
			return $lInterfaz;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Permite buscar una Interfaz de acuerdo a su ID.
	 *
	 * @return modelo::clases::Interfaz
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Interfaz WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultados = $this->select();
	
			$lInterfaz = new Interfaz();
			if ($lResultados) {
				$lInterfaz = $this->cargarObjeto($lResultados[0]);
			}
			
			return $lInterfaz;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function buscarID
			
	public function buscarNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM Interfaz WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultados = $this->select();
	
			$lInterfaz = new Interfaz();
			if ($lResultados) {
				$lInterfaz = $this->cargarObjeto($lResultados[0]);
			}
			
			return $lInterfaz;
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function cargarObjeto($pResultado) { 
		$lInterfaz = new Interfaz($pResultado['IP'], $pResultado['Nombre']);
		$lInterfaz->ID = $pResultado['ID'];
		$lInterfaz->MAC = $pResultado['MAC'];
		$lInterfaz->Descripcion = $pResultado['Descripcion'];
		$lInterfaz->Mascara = $pResultado['Mascara'];
		$lInterfaz->Internet = $pResultado['Internet'];
		
		$lDAOSubred = new DAOSubred();
		$lInterfaz->Subredes = $lDAOSubred->listarPorInterfaz($lInterfaz->ID);
		return $lInterfaz;
	}

} // end of DAOInterfaz
?>
