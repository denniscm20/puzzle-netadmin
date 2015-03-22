<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class ReglaPredefinida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';


/**
 * class ReglaPredefinida
 */
class ReglaPredefinida extends Clase {

	/**
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * @access private
	 */
	private $aDescripcion = "";

	/**
	 * @access private
	 */
	private $aRegla = "";
	
	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
		$this->aDescripcion = "";
		$this->aRegla = "";
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<ReglaPredefinida>".$this->aID."</ReglaPredefinida>");
		
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

} // end of ReglaPredefinida
?>
