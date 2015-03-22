<?php

require_once BASE.'Controlador.php';
require_once DAO_IPTABLES.'DAOReglaIptables.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Interfaz.php';

class ControladorReporteIptables extends Controlador {
	
	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private $aLineasReporte = array();
	private $aFechasReporte = array();

	/**
	* Obtiene una instancia del objeto ControladorReporteIptables
	*
	* @return controlador::ControladorServidor
	* @static
	* @access public
	*/
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorReporteIptables();
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
	
	public function getFechasReporte() {
		return $this->aFechasReporte;
	}
	
	protected function buscar ( ) {
		$lPuertoDestino = isset($_POST["txtPuertoDestino"])?trim($_POST["txtPuertoDestino"]):"";
		$lPuertoOrigen = isset($_POST["txtPuertoOrigen"])?trim($_POST["txtPuertoOrigen"]):"";
		$lIPDestino = isset($_POST["txtIPDestino"])?trim($_POST["txtIPDestino"]):"";
		$lIPOrigen = isset($_POST["txtIPOrigen"])?trim($_POST["txtIPOrigen"]):"";
		$lUltimos = isset($_POST["cmbUltimos"])?$_POST["cmbUltimos"]:"10";
		
		$lFilter = "";
		if ($lPuertoDestino != "") { $lFilter .= " | grep DPT=".$lPuertoDestino;}
		if ($lPuertoOrigen != "") { $lFilter .= " | grep SPT=".$lPuertoOrigen;}
		if ($lIPDestino != "") { $lFilter .= " | grep DST=".$lIPDestino;}
		if ($lIPOrigen != "") { $lFilter .= " | grep SRC=".$lIPOrigen;}
		if ($lUltimos != "") { $lFilter .= " | tail -n ".$lUltimos;}
		
		exec("sudo cat /var/log/iptables/iptables.log | grep Iptables ".$lFilter." | cut -d' ' -f1,2,3,6,7,8,9,10,18,19", $lOutput);
		//exec("sudo cat \$_HOME/iptables.log | grep Iptables ".$lFilter." | cut -d' ' -f1,2,3,6,7,8,9,10,18,19", $lOutput);
		
		foreach ($lOutput as $lLinea) {
			$lReglaIptables = new ReglaIptables();
			$lPos = strpos($lLinea, "'Iptables:'");
			$lFecha = substr($lLinea,0,$lPos);
			$lLinea = str_replace("'Iptables:'","",substr($lLinea,$lPos));
			$lElementos = explode(" ",$lLinea);
			foreach ($lElementos as $lElemento) {
				$lElemento = trim ($lElemento);
				$lValor = explode("=",$lElemento);
				switch (trim($lValor[0])) {
					case "IN":
						$lInterfaz = new Interfaz("",trim($lValor[1]));
						$lDAOInterfaz = new DAOInterfaz($lInterfaz);
						$lReglaIptables->InterfazOrigen = $lDAOInterfaz->buscarNombre();
						break;
					case "OUT":
						$lInterfaz = new Interfaz("",trim($lValor[1]));
						$lDAOInterfaz = new DAOInterfaz($lInterfaz);
						$lReglaIptables->InterfazDestino = $lDAOInterfaz->buscarNombre();
						break;
					case "MAC":
						$lReglaIptables->MAC = trim($lValor[1]);
						break;
					case "SRC":
						$lReglaIptables->IPOrigen = trim($lValor[1]);
						break;
					case "DST":
						$lReglaIptables->IPDestino = trim($lValor[1]);
						break;
					case "SPT":
						$lReglaIptables->PuertoOrigenInicial = trim($lValor[1]);
						break;
					case "DPT":
						$lReglaIptables->PuertoDestinoInicial = trim($lValor[1]);
						break;
				}
			}
			$this->aFechasReporte[] = $lFecha;
			$this->aLineasReporte[] = $lReglaIptables;
		}
		
	}
	
}

?>