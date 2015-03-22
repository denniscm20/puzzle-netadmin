<?php
/**
 * @package /modelo/clases/
 * @class Servidor.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

//require_once CLASES.'IModulo.php';
//require_once CLASES.'IHistorico.php';
require_once BASE.'Clase.php';
require_once CLASES.'Interfaz.php';


/**
 * @class Servidor
 * Esta clase contiene la información básica sobre las configuraciones de red del
 * servidor en donde se ejecuta la aplicación.
 */
class Servidor extends Clase {

	/*** Attributes: ***/
	
	/**
	 * DNS primario del servidor
	 * @access private
	 */
	private $aDNS1 = "";

	/**
	 * DNS Secundario del servidor
	 * @access private
	 */
	private $aDNS2 = "";

	/**
	 * Gateway predeterminado del servidor
	 * @access private
	 */
	private $aGateway = "";

	/**
	 * Determina si el reenvío de paquetes (routing) está habilitado
	 * @access private
	 */
	private $aReenvio = 0;

	/**
	 * Nombre del equipo en donde se halla isntalada la aplicación.
	 * @access private
	 */
	private $aHostname = "";

	/**
	 * Lista de IPv4 hábiles para iniciar sesión en la aplicación.
	 * @access private
	 */
	private $aIpHabiles;
	
	/**
	* Lista de interfaces de red detectadas por la aplicación.
	* @access private
	*/
	private $aInterfaces;

	public function __construct() {
		$this->ID = 0;
		$this->aHostname = "";
		$this->aDNS1 = "";
		$this->aDNS2 = "";
		$this->aReenvio = 0;
		$this->aIpHabiles = array();
		$this->aInterfaces = array();
	}

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


} // end of Servidor
?>
