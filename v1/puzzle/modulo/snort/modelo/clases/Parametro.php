<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class Parametro
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class Parametro
 * Esta clase representa los preprocesadores que el Snort puede utilizar
 */
class Parametro extends Clase {

	/*** Attributes: ***/

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
	private $aValor = "";

	public function __construct($pNombre = "") {
		$this->aID = 0;
		$this->aNombre = $pNombre;
		$this->aDescripcion = "";
		$this->aValor = "";
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Parametro>");
		array_push($lConfiguracion, "<ID>".$this->aID."</ID>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		array_push($lConfiguracion, "<Descripcion>".$this->aDescripcion."</Descripcion>");
		array_push($lConfiguracion, "<Valor>".$this->aValor."</Valor>");
		array_push($lConfiguracion, "</Parametro>");
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
} // end of Parametro
?>
