<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class TipoServicio
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class TipoServicio
 */
class TipoServicio extends Clase {

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * @access private
	 */
	private $aDescripcion = "";

	public function __construct($pNombre = "") {
		$this->aID = 0;
		$this->aNombre = $pNombre;
		$this->aDescripcion = "";
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<TipoServicio>".$this->aID."</TipoServicio>");
		return $lConfiguracion;
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
} // end of TipoServicio
?>
