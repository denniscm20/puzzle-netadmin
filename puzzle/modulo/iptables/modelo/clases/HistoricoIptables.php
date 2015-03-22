<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/HistoricoIptables.php
 * @class modulo/Iptables/modelo/clases/HistoricoIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'IHistorico.php';
require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once CLASES_IPTABLES.'FechaActivacionIptables.php';


/**
 * class HistoricoIptables
 * Esta clase representa cada una de las entradas dentro del registro histórico de
 * configuraciones de Iptables.
 */
class HistoricoIptables extends Clase implements IHistorico  {

	 /*** Attributes: ***/

	/**
	 * Fecha en la que se creó la entrada.
	 * @access private
	 */
	private $aFechaCreacion;

	/**
	 * Hora en la que se creó la entrada.
	 * @access private
	 */
	private $aHoraCreacion;

	/**
	 * Breve descripción de la entrada.
	 * @access private
	 */
	private $aDescripcion = "";
	
	private $aIptables = null;
	
	private $aFechasActivacionIptables = array();

	public function __construct() {
		$this->aID = 0;
		$this->aIptables = new Iptables();
		$this->aFechaCreacion = date("Ymd");
		$this->aHoraCreacion = date("H:i");
		$this->aDescripcion = "";
		$this->aFechasActivacionIptables = array();
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

} // end of HistoricoIptables
?>
