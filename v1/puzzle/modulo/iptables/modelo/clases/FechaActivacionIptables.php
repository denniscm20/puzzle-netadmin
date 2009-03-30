<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/FechaActivacionIptables.php
 * @class modulo/Iptables/modelo/clases/FechaActivacionIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * class FechaActivacionIptables
 * Esta clase representa cada una de las entradas dentro del registro histórico de
 * configuraciones de Iptables.
 */
class FechaActivacionIptables extends Clase
{

	 /*** Attributes: ***/

	/**
	 * Fecha en la que se activó la entrada.
	 * @access private
	 */
	private $aFechaActivacion;

	/**
	 * Hora en la que se activó la entrada.
	 * @access private
	 */
	private $aHoraActivacion;

	public function __construct() {
		$this->aID = 0;
		$this->aFechaActivacion = date("Ymd");
		$this->aHoraActivacion = date("H:i");
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

} // end of FechaActivacionIptables
?>
