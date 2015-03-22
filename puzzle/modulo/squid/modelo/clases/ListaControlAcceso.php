<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class ListaControlAcceso.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES.'Nodo.php';
require_once CLASES_SQUID.'TipoACL.php';

/**
 * class ListaControlAcceso
 * Representa una lista de redes sobre las que se aplica las reglas definidas por
 * el Squid.
 */
class ListaControlAcceso extends Clase {

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aNombre = "";
	
	private $aTipoACL = null;
	
	private $aValores = null;
	 
	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
		$this->aTipoACL = new TipoACL();
		$this->aValores = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<ListaControlAcceso>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aTipoACL->generarXML());
		array_push($lConfiguracion, "<Valores>");
		foreach ($this->aValores as $lValor)
			$lConfiguracion = array_merge($lConfiguracion,$lValor->generarXML());
		array_push($lConfiguracion, "</Valores>");
		array_push($lConfiguracion, "</ListaControlAcceso>");
		
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
	
} // end of ListaControlAcceso
?>
