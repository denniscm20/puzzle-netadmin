<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAO.php
 * @class modelo/dao/DAO.php
 * @author dennis
 * @version 1.0
 */

require_once LIB.'BaseDatos.php';

/**
 * class DAO
 */
abstract class DAO {

	 /*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aBaseDatos = null;

	private $aObjeto = null;
	
	private $aQuery = null;
	 
	/**
	 * Constructor de la clase
	 * @param object pObjeto 
	 * @return 
	 * @access public
	 */
	public function __construct( $pObjeto = null ) {
		$this->aBaseDatos = BaseDatos::obtenerInstancia();
		$this->aObjeto = $pObjeto;
	} // end of member function __construct

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		unset($this->aObjeto);
	} // end of member function __destruct

	/**
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$lResultado = $this->aBaseDatos->insert($this->aQuery);
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
			$lResultado = $this->aBaseDatos->update($this->aQuery);
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
			$lResultado = $this->aBaseDatos->delete($this->aQuery);
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
	public abstract function buscar( );
	
	/**
	*
	* @return array
	* @access public
	*/
	public abstract function cargarValores( );
	
	public abstract function buscarID( );

	public abstract function listarTodos( );
	

} // end of DAOUsuario
?>
