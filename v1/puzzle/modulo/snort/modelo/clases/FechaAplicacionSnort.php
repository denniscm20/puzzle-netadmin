<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class FechaAplicacionSnort
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class FechaAplicacionSnort
 */
class FechaAplicacionSnort extends Clase {

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aFechaAplicacion = "";

	/**
	 * @access private
	 */
	private $aHoraAplicacion = "";

	public function __construct() {
		$this->aID = 0;
		$this->aFechaAplicacion = date("Ymd");
		$this->aHoraAplicacion = date("H:i");
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

} // end of FechaAplicacionSnort
?>
