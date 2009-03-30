<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/clases/Interfaz.php
 * @class modelo/clases/Interfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';

/**
 * @class Interfaz
 * Esta clase representa a una zona dentro de la red local, conectada al servidor a
 * través de una interfaz de red.
 */
class Interfaz extends Clase {

	/*** Attributes: ***/
	
	/**
	 * IP versión 4 asignado a la interfaz de red.
	 * @access private
	 */
	private $aIP = "0.0.0.0";

	/**
	 * MAC asignada a la interfaz de red.
	 * @access private
	 */
	private $aMAC = "";

	/**
	 * Nombre aignado a la interfaz de red.
	 * @access private
	 */
	private $aNombre = "";

	/**
	 * Breve descripción del uso de la interfaz.
	 * @access private
	 */
	private $aDescripcion = "";
	
	/**
	* Máscara de la interfaz.
	* @access private
	*/
	private $aMascara = "";
	
	/**
	 * Indica si la interfaz es utilizada para conexión a Internet.
	 * @access private
	 */
	private $aInternet = false;
	
	/**
	* Conjunto de subredes que la interfaz agrupa
	* @access private
	*/
	private $aSubredes = array();

	public function __construct($pIP = "0.0.0.0", $pNombre = "") {
		$this->aIP = $pIP;
		$this->aNombre = $pNombre;
		$this->aDescripcion = "";
		$this->aMascara = "";
		$this->aInternet = false;
		$this->aSubredes = array();
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


} // end of Interfaz
?>
