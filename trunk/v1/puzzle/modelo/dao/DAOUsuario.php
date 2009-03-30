<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAOUsuario.php
 * @class modelo/dao/DAOUsuario.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'Usuario.php';
require_once BASE.'DAO.php';


/**
 * class DAOUsuario
 */
class DAOUsuario extends DAO {

	 /**
	 * Constructor de la clase
	 * @param modelo::clases::Usuario pUsuario 
	 * @return 
	 * @access public
	 */
	public function __construct( $pUsuario = null ) {
		parent::__construct($pUsuario);
	} // end of member function __construct

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		parent::__destruct();
	} // end of member function __destruct

	/**
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$this->aQuery = "INSERT INTO Usuario (Nombre,Password,Administrador) VALUES (?,?,0)";
			$this->aParameters = array($this->aObjeto->Nombre, $this->aObjeto->Password);
			$lResultado = $this->insert();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregarUsuario

	/**
	 *
	 * @return int
	 * @access public
	 */
	public function modificar( ) {
		try {
			$this->aQuery = "UPDATE Usuario SET Nombre = ?,Password = ? WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->Nombre, $this->aObjeto->Password, $this->aObjeto->ID);
			$lResultado = $this->update();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function modificarUsuario

	/**
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM Usuario WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->delete();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminarUsuario

	/**
	 *
	 * @return array
	 * @access public
	 */
	public function buscar( ) {
		try {
			$this->aQuery = "SELECT * FROM Usuario WHERE Nombre = ? AND Password = ?";
			$this->aParameters = array($this->aObjeto->Nombre, $this->aObjeto->Password);
			$lResultado = $this->select();
			
			$lUsuarios = array();
			foreach ($lResultado as $lElemento) {
				$lUsuarios[] = $this->cargarObjeto($lElemento);
			}
			return $lUsuarios;
		} catch (Exception $e) {
			throw $e;
		}
		
	} // end of member function buscarUsuario
			
	/**
	 *
	 * @return array
	 * @access public
	 */
	public function buscarPorNombre( ) {
		try {
			$this->aQuery = "SELECT * FROM Usuario WHERE Nombre = ?";
			$this->aParameters = array($this->aObjeto->Nombre);
			$lResultado = $this->select();
			
			$lUsuarios = array();
			foreach ($lResultado as $lElemento) {
				$lUsuarios[] = $this->cargarObjeto($lElemento);
			}
			
			return $lUsuarios;
		} catch (Exception $e) {
			throw $e;
		}
		
	} // end of member function buscarUsuario
			
	public function buscarID( ) {
		try {
			$this->aQuery = "SELECT * FROM Usuario WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->select();

			$lUsuario = new Usuario();
			if ($lResultado) {
				$lUsuario = $this->cargarObjeto($lResultado[0]);
			}
		
			return $lUsuario;
		} catch (Exception $e) {
			throw $e;
		}
		
	} // end of member function buscarUsuario

	/**
	 * Lista todos los usuarios registrados en la aplicación.
	 *
	 * @return array
	 * @access public
	 */
	public function listarTodos() {
		try {
			$this->aQuery = "SELECT * FROM Usuario";
			
			$lResultado = $this->select();
			
			$lUsuarios = array();
			foreach ($lResultado as $lElemento) {
				$lUsuarios[] = $this->cargarObjeto($lElemento);
			}
			
			return $lUsuarios;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($lElemento) {
		$lUsuario = new Usuario();
		$lUsuario->ID = $lElemento['ID'];
		$lUsuario->Nombre = $lElemento['Nombre'];
		$lUsuario->Password = $lElemento['Password'];
		$lUsuario->Administrador = $lElemento['Administrador'];

		return $lUsuario;
	}

} // end of DAOUsuario
?>
