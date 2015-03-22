<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/Cadena.php
 * @class modulo/Iptables/modelo/clases/Cadena.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once CLASES_IPTABLES.'Politica.php';

/**
 * class Cadena
 * Esta clase representa una cadena de Iptables.  Las cadenas por defecto son
 * INPUT, OUTPUT y FORWARD.
 */
class Cadena extends Clase {

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

	/**
	* Política predeterminada asignada a la cadena.  Puede ser la de autorizar (ALLOW)
	* o la de rechazar (DROP).
	* @access private
	*/
	private $aPolitica = null;
	
	/** Compositions: */
	private $aReglasIptables = null;

	 /*** Attributes: ***/

	public function __construct($pNombre = "") {
		$this->aNombre = $pNombre;
		$this->aPolitica = new Politica();
		$this->aReglasIptables = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Cadena>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		array_push($lConfiguracion, "<Descripcion>".$this->aDescripcion."</Descripcion>");
		$lConfiguracion = array_merge($lConfiguracion, $this->aPolitica->generarXML());
		array_push($lConfiguracion, "<ReglasIptables>");
		foreach ($this->aReglasIptables as $lReglaIptables)
			$lConfiguracion = array_merge($lConfiguracion, $lReglaIptables->generarXML());
		array_push($lConfiguracion, "</ReglasIptables>");
		array_push($lConfiguracion, "</Cadena>");
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

} // end of Cadena
?>
