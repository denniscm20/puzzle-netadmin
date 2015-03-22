<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/clases/Subred.php
 * @class modelo/clases/Subred.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES.'Nodo.php';

/**
 * class Subred
 * Esta clase representa a una subred dentro de una red local.
 */
class Subred extends Clase {

	/*** Attributes: ***/

	/**
	 * Nombre de la subred
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * IP de la subred
	 * @access private
	 */
	private $aIP = "";

	/**
	 * Máscara de la subred.
	 * @access private
	 */
	private $aMascara = "";

	/**
	 * Formato corto de la máscara de la subred.
	 * @access private
	 */
	private $aMascaraCorta = "";
	
	private $aNodos = array();
	
	public function __construct ($pIP = "", $pMascara = "") {
		$this->aIP = $pIP;
		$this->aMascara = $pMascara;
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

} // end of Subred
		?>
