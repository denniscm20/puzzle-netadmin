<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/Protocolo.php
 * @class modulo/Iptables/modelo/clases/Protocolo.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'Protocolo.php';

/**
 * class Protocolo
 * Esta clase representa las acciones a ejecutar sobre cada regla que se defina.
 */
class Protocolo extends Clase {

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

	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
	}

	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Protocolo>".$this->aID."</Protocolo>");
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

} // end of Protocolo
?>
