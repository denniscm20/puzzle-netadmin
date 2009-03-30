<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class PuertoSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES.'Interfaz.php';


/**
 * class PuertoSquid
 */
class PuertoSquid extends Clase {

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aPuerto = 3128;

	/**
	 * @access private
	 */
	private $aDescripcion = "";
	
	private $aInterfaz = null;
	
	public function __construct() {
		$this->aPuerto = 3128;
		$this->aDescripcion = "";
		$this->aInterfaz = new Interfaz();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<PuertoSquid>");
		array_push($lConfiguracion, "<Puerto>".$this->aPuerto."</Puerto>");
		array_push($lConfiguracion, "<Descripcion>".$this->aDescripcion."</Descripcion>");
		array_push($lConfiguracion, "<Interfaz>".$this->aInterfaz->ID."</Interfaz>");
		array_push($lConfiguracion, "</PuertoSquid>");
		
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
	
} // end of PuertoSquid
?>
