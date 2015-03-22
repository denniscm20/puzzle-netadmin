<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/clases/RegistroHistorico.php
 * @class modelo/clases/RegistroHistorico.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class RegistroHistorico
 * Esta clase contiene información del usuario que iniciado sesión en la
 * aplicación.
 */
class RegistroHistorico extends Clase {

	/*** Attributes: ***/

	private $aFecha;
	private $aHora;
	private $aIP;
	private $aBrowser;
	private $aUsuario;
	private $aMensaje;

	/**
	 * Método constructor de la clase RegistroHistorico
	 *
	 * @param string pNombre Nombre del usuario
	 * @param string pPassword Contraseña del usuario
	 * @return 
	 * @access public
	 */
	public function __construct( $pUsuario = "", $pMensaje = "" ) {
		$this->aFecha = date("Ymd");
		$this->aHora = date("H:i");
		$this->aUsuario = $pUsuario;
		$this->aMensaje = $pMensaje;
		$this->aIP = $_SERVER['REMOTE_ADDR'];
		$this->aBrowser = $_SERVER['HTTP_USER_AGENT'];
	} // end of member function __construct

	/**
	 * Método destructor de la clase RegistroHistorico
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		
	} // end of member function __destruct

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

} // end of RegistroHistorico
?>
