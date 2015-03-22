<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/Table.php
 * @class modulo/Iptables/modelo/clases/Table.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'Cadena.php';

/**
 * class Table
 * Esta clase representa una cadena de Iptables.  Las cadenas por defecto son
 * INPUT, OUTPUT y FORWARD.
 */
class Table extends Clase {

	/**
	* Nombre de la cadena.
	* @access private
	*/
	private $aNombre = "";
	
	/**
	* Descripcion de la cadena.
	* @access private
	*/
	private $aDescripcion = "";

	/** Compositions: */
	private $aCadenas = null;

	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
		$this->aCadenas = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Table>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		array_push($lConfiguracion, "<Descripcion>".$this->aDescripcion."</Descripcion>");
		array_push($lConfiguracion, "<Cadenas>");
		foreach ($this->aCadenas as $lCadena)
			$lConfiguracion = array_merge($lConfiguracion, $lCadena->generarXML());
		array_push($lConfiguracion, "</Cadenas>");
		array_push($lConfiguracion, "</Table>");
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

} // end of Table
?>