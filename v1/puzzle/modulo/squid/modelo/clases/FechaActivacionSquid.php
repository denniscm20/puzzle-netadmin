<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class FechaActivacionSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';


/**
 * class FechaAplicacionSquid
 */
class FechaActivacionSquid extends Clase {
	
	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aFechaActivacion = "";

	/**
	 * @access private
	 */
	private $aHoraActivacion = "";
	
	public function __construct() {
		$this->aFechaActivacion = date("Ymd");
		$this->aHoraActivacion = date("H:i");
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
	
} // end of FechaAplicacionSquid
?>
