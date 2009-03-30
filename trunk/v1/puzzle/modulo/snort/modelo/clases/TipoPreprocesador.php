<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class TipoPreprocesador
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SNORT.'Parametro.php';

/**
 * class TipoPreprocesador
 */
class TipoPreprocesador extends Clase {

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * @access private
	 */
	private $aDescripcion = "";
	
	private $aParametros = null;

	public function __construct($pNombre = "") {
		$this->aID = 0;
		$this->aNombre = $pNombre;
		$this->aDescripcion = "";
		$this->aParametros = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<TipoPreprocesador>".$this->aID."</TipoPreprocesador>");
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
} // end of TipoPreprocesador
?>
