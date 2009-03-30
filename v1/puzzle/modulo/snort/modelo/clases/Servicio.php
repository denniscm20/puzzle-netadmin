<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class Servicio
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES.'Nodo.php';
require_once CLASES_SNORT.'TipoServicio.php';


/**
 * class Servicio
 */
class Servicio extends Clase {

	/** Compositions: */
	private $aNodos = null;
	private $aTipoServicio = null;

	 /*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * @access private
	 */
	private $aPuertos = "";

	/**
	 * @access private
	 */
	private $aDescripcion = "";

	public function __construct($pNombre = "") {
		$this->aID = 0;
		$this->aNombre = $pNombre;
		$this->aDescripcion = "";
		$this->aPuertos = "";
		$this->aNodos = array();
		$this->aTipoServicio = new TipoServicio();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Servicio>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		array_push($lConfiguracion, "<Descripcion>".$this->aDescripcion."</Descripcion>");
		array_push($lConfiguracion, "<Puertos>".$this->aPuertos."</Puertos>");
		array_push($lConfiguracion, "<Nodos>");
		foreach ($this->aNodos as $lNodo)
			array_push($lConfiguracion, "<Nodo>".$lNodo->ID."</Nodo>");
		array_push($lConfiguracion, "</Nodos>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aTipoServicio->generarXML());
		array_push($lConfiguracion, "</Servicio>");
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

} // end of Servicio
?>
