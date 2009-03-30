<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/clases/IPv4Valida.php
 * @class modelo/clases/IPv4Valida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class IPv4Valida
 * Esta clase representa cada dirección desde la cual se podrá acceder al sistema.
 */
class IPv4Valida extends Clase {

	 /*** Attributes: ***/
 
	/**
	 * Dirección IP del registro.
	 * @access private
	 */
	private $aIP = "0.0.0.0";
	
	public function __construct($pIP = "0.0.0.0") {
		$this->aIP = $pIP;
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


} // end of IPv4Valida
?>
