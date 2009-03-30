<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class HistoricoSquid.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SQUID.'Squid.php';
require_once BASE.'IHistorico.php';
require_once CLASES_SQUID.'FechaActivacionSquid.php';


/**
 * class HistoricoSquid
 * Esta clase representa cada una de las entradas dentro del registro histórico de
 * configuraciones de Squid.
 */
class HistoricoSquid extends Clase implements IHistorico {

	/*** Attributes: ***/
	private $aSquid = null;
	private $aFechasActivacionSquid = array();

	/**
	 * Fecha en la que se registró la entrada.
	 * @access private
	 */
	private $aFechaCreacion;

	/**
	 * Hora en la que se registró la entrada.
	 * @access private
	 */
	private $aHoraCreacion;

	/**
	 * Breve descripción de la entrada registrada en el registro histórico del módulo
	 * Squid.
	 * @access private
	 */
	private $aDescripcion = "";


	public function __construct($pNombre = "") {
		$this->aSquid = new Squid();
		$this->aFechasActivacionSquid = array();
		$this->aFechaCreacion = date("Ymd");
		$this->aHoraCreacion = date("H:i");
		$this->aDescripcion = "";
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


} // end of HistoricoSquid
?>
