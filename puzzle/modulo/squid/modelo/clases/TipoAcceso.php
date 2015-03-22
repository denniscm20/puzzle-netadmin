<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class TipoAcceso.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';


/**
 * class TipoAcceso
 */
class TipoAcceso extends Clase {

	/**
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * @access private
	 */
	private $aDescripcion = "";

	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<TipoAcceso>".$this->aID."</TipoAcceso>");
		
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

} // end of TipoAcceso
?>
