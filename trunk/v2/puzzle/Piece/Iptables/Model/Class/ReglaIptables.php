<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/ReglaIptables.php
 * @class modulo/Iptables/modelo/clases/ReglaIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES.'Interfaz.php';
require_once CLASES_IPTABLES.'Protocolo.php';
require_once CLASES_IPTABLES.'Estado.php';
require_once CLASES_IPTABLES.'Accion.php';


/**
 * class ReglaIptables
 * Esta clase representa cada una de las reglas que pueden ser registradas en la
 * aplicación Iptables.
 */
class ReglaIptables extends Clase {

	 /*** Attributes: ***/

	/**
	 * Puerto de origen sobre el que se aplica la regla.
	 * @access private
	 */
	private $aPuertoOrigenInicial = "";
	private $aPuertoOrigenFinal = "";

	/**
	 * Puerto de destino sobre el que se aplica la regla..
	 * @access private
	 */
	private $aPuertoDestinoInicial = "";
	private $aPuertoDestinoFinal = "";

	/**
	 * Ip de origen sobre el que se aplica la regla..
	 * @access private
	 */
	private $aIPOrigen = "";
	private $aMascaraOrigen = "";

	/**
	 * Protocolo sobre el que se aplica la regla.
	 * @access private
	 */
	private $aProtocolo = null;

	/**
	 * Interfaz de destino sobre el que se aplica la regla.
	 * @access private
	 */
	private $aInterfazDestino = null;

	/**
	 * Ip de destino sobre el que se aplica la regla.
	 * @access private
	 */
	private $aIPDestino = "";
	private $aMascaraDestino = "";

	/**
	 * Acción a efectuar (autorizar, denegar, loguear)
	 * @access private
	 */
	private $aAccion = null;

	/**
	 * Interfaz de origen sobre el que se aplica la regla.
	 * @access private
	 */
	private $aInterfazOrigen = null;

	/**
	 * Permite generar reglas basándose en los estados de las conexiones.
	 * @access private
	 */
	private $aEstado = null;

	/**
	 * Atributo utilizado en caso se desee filtrar por dirección MAC.
	 * @access private
	 */
	private $aMAC = "";
	
	public function __construct() {
		$this->aPuertoOrigenInicial = "";
		$this->aPuertoOrigenFinal = "";
		$this->aPuertoDestinoInicial = "";
		$this->aPuertoDestinoFinal = "";
		$this->aIPOrigen = "";
		$this->aMascaraOrigen = "";
		$this->aProtocolo = new Protocolo();
		$this->aInterfazDestino = new Interfaz();
		$this->aIPDestino = "";
		$this->aMascaraDestino = "";
		$this->aAccion = new AccionIptables();
		$this->aInterfazOrigen = new Interfaz();
		$this->aEstado = new Estado();
		$this->aMAC = "";
	}
	
	public function generarXML() {
		$lConfiguracion = array();

		array_push($lConfiguracion, "<ReglaIptables>");
		array_push($lConfiguracion, "<PuertoOrigenInicial>".$this->aPuertoOrigenInicial."</PuertoOrigenInicial>");
		array_push($lConfiguracion, "<PuertoOrigenFinal>".$this->aPuertoOrigenFinal."</PuertoOrigenFinal>");
		array_push($lConfiguracion, "<PuertoDestinoInicial>".$this->aPuertoDestinoInicial."</PuertoDestinoInicial>");
		array_push($lConfiguracion, "<PuertoDestinoFinal>".$this->aPuertoDestinoFinal."</PuertoDestinoFinal>");
		array_push($lConfiguracion, "<IPOrigen>".$this->aIPOrigen."</IPOrigen>");
		array_push($lConfiguracion, "<MascaraOrigen>".$this->aMascaraOrigen."</MascaraOrigen>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aProtocolo->generarXML());
		array_push($lConfiguracion, "<InterfazDestino>");
		array_push($lConfiguracion, "<IP>".$this->aInterfazDestino->IP."</IP>");
		array_push($lConfiguracion, "<Nombre>".$this->aInterfazDestino->Nombre."</Nombre>");
		array_push($lConfiguracion, "</InterfazDestino>");
		array_push($lConfiguracion, "<IPDestino>".$this->aIPDestino."</IPDestino>");
		array_push($lConfiguracion, "<MascaraDestino>".$this->aMascaraDestino."</MascaraDestino>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aAccion->generarXML());
		array_push($lConfiguracion, "<InterfazOrigen>");
		array_push($lConfiguracion, "<IP>".$this->aInterfazOrigen->IP."</IP>");
		array_push($lConfiguracion, "<Nombre>".$this->aInterfazOrigen->Nombre."</Nombre>");
		array_push($lConfiguracion, "</InterfazOrigen>");
		$lConfiguracion = array_merge($lConfiguracion,$this->aEstado->generarXML());
		array_push($lConfiguracion, "<MAC>".$this->aMAC."</MAC>");
		array_push($lConfiguracion, "</ReglaIptables>");
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

} // end of ReglaIptables
?>
