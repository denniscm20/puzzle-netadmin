<?php

require_once BASE.'Controlador.php';
require_once DAO_SNORT.'DAOReglaPredefinida.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Interfaz.php';

class ControladorReporteSnort extends Controlador {
	
	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private $aLineasReporte = array();

	/**
	* Obtiene una instancia del objeto ControladorReporteSnort
	*
	* @return controlador::ControladorServidor
	* @static
	* @access public
	*/
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorReporteSnort();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia
	
	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "buscar":
				$this->{$pEvento}();
				break;
			default:
				$this->buscar();
				break;
		}
	}
	
	public function getLineasReporte() {
		return $this->aLineasReporte;
	}
	
	protected function buscar ( ) {
		$lPuertoDestino = isset($_POST["txtPuertoDestino"])?trim($_POST["txtPuertoDestino"]):"";
		$lPuertoOrigen = isset($_POST["txtPuertoOrigen"])?trim($_POST["txtPuertoOrigen"]):"";
		$lIPDestino = isset($_POST["txtIPDestino"])?trim($_POST["txtIPDestino"]):"";
		$lIPOrigen = isset($_POST["txtIPOrigen"])?trim($_POST["txtIPOrigen"]):"";
		$lUltimos = isset($_POST["cmbUltimos"])?$_POST["cmbUltimos"]:"10";
		
		$lFilter = "";
		if ($lIPDestino != "" && $lPuertoDestino == "") { 
			$lFilter .= " | grep -e \"-> ".$lIPDestino."\"";
		}
		if ($lIPDestino != "" && $lPuertoDestino != "") { 
			$lFilter .= " | grep -e \"-> ".$lIPDestino.":".$lPuertoDestino."\"";
		}
		if ($lIPOrigen != "" && $lPuertoOrigen == "") { 
			$lFilter .= " | grep -e \"} ".$lIPOrigen."\"";
		}
		if ($lIPOrigen != "" && $lPuertoOrigen != "") { 
			$lFilter .= " | grep -e \"} ".$lIPOrigen.":".$lPuertoOrigen." \"";
		}
		if ($lUltimos != "") { 
			$lFilter .= " | tail -n ".$lUltimos;
		}
		
		exec("sudo cat /var/log/snort/alert".$lFilter, $lOutput);
		
		$this->aLineasReporte = array();
		$lDelimiter = " [**] ";
		$lDelimiterSize = strlen($lDelimiter);
		foreach ($lOutput as $lLinea) {
			$lRegistro = array();
			$lPos = strpos($lLinea, $lDelimiter);
			$lFecha = substr($lLinea,0,$lPos);
			$lRegistro["Fecha"] = substr($lFecha,0,strpos($lFecha, "."));
			$lLinea = substr($lLinea,$lPos + $lDelimiterSize);
			$lPos = strpos($lLinea, $lDelimiter);
			$lMensaje = substr($lLinea,0,$lPos);
			$lRegistro["Mensaje"] = substr($lMensaje,strpos($lMensaje, "] ") + 1);
			$lRegistro["Informacion"] = substr($lLinea,$lPos + $lDelimiterSize);
			
			$this->aLineasReporte[] = $lRegistro;
		}
		
	}
	
}

?>