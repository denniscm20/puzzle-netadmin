<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class ReglaSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SQUID.'Accion.php';
require_once CLASES_SQUID.'TipoAcceso.php';
require_once CLASES_SQUID.'ListaControlAcceso.php';

/**
 * class ReglaSquid
 */
class ReglaSquid extends Clase {

	/*** Attributes: ***/
	private $aAccion = null;
	private $aTipoAcceso = null;
	private $aListaControlAcceso = null;
	
	public function __construct($pNombre = "") {
		$this->aAccion = new Accion();
		$this->aTipoAcceso = new TipoAcceso();
		$this->aListaControlAcceso = new ListaControlAcceso();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<ReglaSquid>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aAccion->generarXML());
		$lConfiguracion = array_merge($lConfiguracion,$this->aTipoAcceso->generarXML());
		$lConfiguracion = array_merge($lConfiguracion,$this->aListaControlAcceso->generarXML());
		array_push($lConfiguracion, "</ReglaSquid>");
		
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
	
} // end of ReglaSquid
?>
