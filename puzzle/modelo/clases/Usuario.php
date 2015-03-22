<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/clases/Usuario.php
 * @class modelo/clases/Usuario.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class Usuario
 * Esta clase contiene información del usuario que iniciado sesión en la
 * aplicación.
 */
class Usuario extends Clase {

	/*** Attributes: ***/

	/**
	 * Nombre del usuario
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * Contraseña del usuario
	 * @access private
	 */
	private $aPassword = "";

	/**
	 * El usuario es administrador
	 * @access private
	 */
	private $aAdministrador = true;


	/**
	 * Método constructor de la clase Usuario
	 *
	 * @param string pNombre Nombre del usuario
	 * @param string pPassword Contraseña del usuario
	 * @return 
	 * @access public
	 */
	public function __construct( $pNombre = "",  $pPassword = "" ) {
		$this->aNombre = $pNombre;
		$this->aPassword = $pPassword;
	} // end of member function __construct

	/**
	 * Método destructor de la clase Usuario
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		
	} // end of member function __destruct

	/**
	 * Indica si el usuario logueado es administrador
	 *
	 * @return bool
	 * @access public
	 */
	public function esAdministrador( ) {
		return $this->aAdministrador;
	} // end of member function esAdministrador
			

	public function __get($pAtributo) {
		$lAtributo = "a".$pAtributo;
		if (isset($this->{$lAtributo})) {
			return $this->{$lAtributo};
		} 
		return $pAtributo;
	}
	
	public function __set($pAtributo, $pValor) {
		$lAtributo = "a".$pAtributo;
		if (isset($this->{$lAtributo})) {
			$this->{$lAtributo} = $pValor;
		} 
		return $pAtributo;
	}

} // end of Usuario
?>
