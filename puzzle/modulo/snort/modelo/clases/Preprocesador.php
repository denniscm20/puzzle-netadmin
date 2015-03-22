<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class Preprocesador
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SNORT.'TipoPreprocesador.php';
require_once CLASES_SNORT.'Parametro.php';


/**
 * class Preprocesador
 * Esta clase representa los preprocesadores que el Snort puede utilizar
 */
class Preprocesador extends Clase {

	/** Aggregations: */

	private $aTipoPreprocesador = null;
	private $aParametros = null;

	/**
	 * @access private
	 */
	private $aOpciones = "";

	public function __construct() {
		$this->aID = 0;
		$this->aTipoPreprocesador = new TipoPreprocesador();
		$this->aParametros = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Preprocesador>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aTipoPreprocesador->generarXML());
		array_push($lConfiguracion, "<Parametros>");
		foreach ($this->aParametros as $lParametro)
			$lConfiguracion = array_merge($lConfiguracion,$lParametro->generarXML());
		array_push($lConfiguracion, "</Parametros>");
		array_push($lConfiguracion, "</Preprocesador>");
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
} // end of Preprocesador
?>
