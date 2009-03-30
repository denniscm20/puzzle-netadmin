<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class Valor.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';


/**
 * class Valor
 */
class Valor extends Clase {

	 /*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aNombre = "";

	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Valor><Nombre>".$this->aNombre."</Nombre></Valor>");
		
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

} // end of Valor
?>
