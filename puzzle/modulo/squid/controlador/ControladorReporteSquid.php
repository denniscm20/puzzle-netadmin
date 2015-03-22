<?php

require_once BASE.'Controlador.php';
require_once DAO_SQUID.'DAOSquid.php';
require_once CLASES_SQUID.'Squid.php';
require_once DAO.'DAOInterfaz.php';
require_once CLASES.'Interfaz.php';

class ControladorReporteSquid extends Controlador {
	
	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private $aLineasReporte = array();
	private $aFechasReporte = array();

	/**
	* Obtiene una instancia del objeto ControladorReporteSquid
	*
	* @return controlador::ControladorServidor
	* @static
	* @access public
	*/
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorReporteSquid();
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
		$lDAOSquid = new DAOSquid();
		$lSquid = $lDAOSquid->buscarActivo();
		
		$lLogName = "";
		$lLog = isset($_GET["Log"])?$_GET["Log"]:"Cache";
		switch ($lLog) {
			case "Cache": $lLogName = $lSquid->CacheLog; break;
			case "Store": $lLogName = $lSquid->StoreLog; break;
			case "Access": $lLogName = $lSquid->AccessLog; break;
		}
		
		$lUltimos = isset($_POST["cmbUltimos"])?$_POST["cmbUltimos"]:"10";
		$lFilter = "";
		if ($lUltimos != "") { $lFilter .= " | tail -n ".$lUltimos;}
		
		
		switch ($lLog) {
			case "Cache": 
				exec("sudo cat ".$lLogName." | grep \"|\" ".$lFilter, $lOutput);
				foreach ($lOutput as $lLinea) {
					$lValor = explode("|",$lLinea);
					$this->aFechasReporte[] = $lValor[0];
					$this->aLineasReporte[] = $lValor[1];
				}
				break;
			case "Store":
				exec("sudo cat ".$lLogName." ".$lFilter, $lOutput);
				foreach ($lOutput as $lLinea) {
					while (strpos($lLinea, "  ") !== FALSE) {
						$lLinea = str_replace("  "," ",$lLinea);
					}
					
					$lValor = explode(" ",$lLinea);
					
					$this->aFechasReporte[] = trim($lValor[0]);
					$this->aLineasReporte[] = array($lValor[1],($lValor[2] == -1)?"unparsable":"missing",$lValor[5],$lValor[9],$lValor[11]);
				}
				break;
			case "Access": 
				exec("sudo cat ".$lLogName." ".$lFilter, $lOutput);
				foreach ($lOutput as $lLinea) {
					while (strpos($lLinea, "  ") !== FALSE) {
						//echo str_replace(" ","&nbsp;",$lLinea)."<br>";
						$lLinea = str_replace("  "," ",$lLinea);
					}
					
					$lValor = explode(" ",$lLinea);
					
					$this->aFechasReporte[] = trim($lValor[0]);
					$this->aLineasReporte[] = array($lValor[1]/1000,$lValor[2],$lValor[3],$lValor[4],$lValor[6],$lValor[9]);
				}
				break;
		}
		
	}
	
}

?>