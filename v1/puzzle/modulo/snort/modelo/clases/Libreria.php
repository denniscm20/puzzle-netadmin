<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class Libreria
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SNORT.'TipoLibreria.php';
require_once CLASES_SNORT.'TipoValor.php';


/**
 * class Libreria
 */
class Libreria extends Clase {

	/** Aggregations: */

	private $aTipoLibreria = null;
	private $aTipoValor = null;

	/** Compositions: */

	 /*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aValor = "";

	public function __construct($pNombre = "") {
		$this->aID = 0;
		$this->aValor = "";
		$this->aTipoLibreria = new TipoLibreria();
		$this->aTipoValor = new TipoValor();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Libreria>");
		array_push($lConfiguracion, "<Valor>".$this->aValor."</Valor>");
		$lConfiguracion = array_unique(array_merge($lConfiguracion,$this->aTipoLibreria->generarXML()));
		$lConfiguracion = array_unique(array_merge($lConfiguracion,$this->aTipoValor->generarXML()));
		array_push($lConfiguracion, "</Libreria>");
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
} // end of Libreria
?>
