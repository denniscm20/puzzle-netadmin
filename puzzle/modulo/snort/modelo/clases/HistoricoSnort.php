<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class FechaAplicacionSnort
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SNORT.'Snort.php';
require_once BASE.'IHistorico.php';
require_once CLASES_SNORT.'FechaAplicacionSnort.php';


/**
 * class HistoricoSnort
 * Esta aplicación representa cada una de las entradas dentro del registro
 * histórico de configuraciones de Snort.
 */
class HistoricoSnort extends Clase implements IHistorico {

	/*** Attributes: ***/

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
	 * Breve descripción de la entrada en el registro histórico del módulo Snort.
	 * @access private
	 */
	private $aDescripcion = "";
	
	private $aSnort = null;
	
	private $aFechasAplicacionSnort = null;

	public function __construct($pNombre = "") {
		$this->aSnort = new Snort();
		$this->aFechasAplicacionSnort = array();
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
} // end of HistoricoSnort
?>
