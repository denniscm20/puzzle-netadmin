<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Politica/modelo/clases/Politica.php
 * @class modulo/Politica/modelo/clases/Politica.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class Politica
 * Esta clase representa las Politicas.
 */
class Politica extends Clase {

	/*** Attributes: ***/
	private $aNombre = "";
	private $aDescripcion = "";

	public function __construct($pNombre = "") {
		 $this->aNombre = $pNombre;
		 $this->aDescripcion = "";
	}

	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Politica>".$this->aID."</Politica>");
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

} // end of Politica
?>
