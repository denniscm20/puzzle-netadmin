<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class TipoLibreria
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class TipoLibreria
 */
class TipoLibreria extends Clase {

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
		array_push($lConfiguracion, "<TipoLibreria>".$this->aID."</TipoLibreria>");
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
} // end of TipoLibreria
?>
