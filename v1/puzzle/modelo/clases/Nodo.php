<?php
/**
 * @package /modelo/clases/
 * @class Nodo.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * @class Nodo
 * Esta clase representa a un nodo dentro de una zona de la red local.
 */
class Nodo extends Clase {

	/*** Attributes: ***/

	/**
	 * Nombre del nodo de la red
	 * @access private
	 */
	private $aHostname = "";

	/**
	 * IP versión 4 asignado al nodo de la red
	 * @access private
	 */
	private $aIP = "";

	public function __construct($pIP = "0.0.0.0", $pHostname = "") {
		$this->aIP = $pIP;
		$this->aHostname = $pHostname;
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

} // end of Nodo
?>
