<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/DetalleReglaPredefinida.php
 * @class modulo/Iptables/modelo/clases/DetalleReglaPredefinida.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES.'Nodo.php';
require_once CLASES.'Interfaz.php';


/**
 * class DetalleReglaPredefinida
 * Esta clase representa cada una de las reglas predefinidas para la aplicación.
 */
class DetalleReglaPredefinida extends Clase {

	/*** Attributes: ***/

	private $aRegla;
	
	public function __construct() {
		$this->aID = 0;
		$this->aRegla = "";
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<DetalleReglaPredefinida>".$this->aID."</DetalleReglaPredefinida>");
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

} // end of DetalleReglaPredefinida
?>
