<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/Estado.php
 * @class modulo/Iptables/modelo/clases/Estado.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'Estado.php';

/**
 * class Estado
 * Esta clase representa los estados de las conexiones.
 */
class Estado extends Clase {

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
		array_push($lConfiguracion, "<Estado>".$this->aID."</Estado>");
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

} // end of Estado
?>
