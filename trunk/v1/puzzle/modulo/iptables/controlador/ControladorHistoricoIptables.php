<?php

require_once BASE.'Controlador.php';
require_once DAO_IPTABLES.'DAOHistoricoIptables.php';
require_once DAO_IPTABLES.'DAOFechaActivacionIptables.php';
require_once DAO_IPTABLES.'DAOIptables.php';
require_once DAO_IPTABLES.'DAOReglaIptables.php';
require_once DAO_IPTABLES.'DAOReglaPredefinida.php';
require_once LIB.'File.php';

class ControladorHistoricoIptables extends Controlador {
	
	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private $aHistoricosIptables = array();

	/**
	* Obtiene una instancia del objeto ControladorServidor
	*
	* @return controlador::ControladorServidor
	* @static
	* @access public
	*/
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorHistoricoIptables();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia
	
	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "buscar":
			case "exportar":
			case "aplicar":
			case "cargar":
			case "eliminar";
				$this->{$pEvento}();
				break;
		}
		
		$this->buscar();
	}
	
	public function getHistoricosIptables() {
		return $this->aHistoricosIptables;
	}
	
	protected function buscar ( ) {
		$lDAOHistorico = new DAOHistoricoIptables();
		
		if (isset($_POST["txtFechaInicio"]) and isset($_POST["txtFechaFin"])) {
			$lFechaInicio = (trim($_POST["txtFechaInicio"]) != "")?date("Ymd",strtotime(trim($_POST["txtFechaInicio"]))):"00000000";
			$lFechaFin = (trim($_POST["txtFechaFin"]) != "")?date("Ymd",strtotime(trim($_POST["txtFechaFin"]))):date("Ymd");
			
			$this->aHistoricosIptables = $lDAOHistorico->listarPorFecha($lFechaInicio, $lFechaFin);
		} else {
			$this->aHistoricosIptables = $lDAOHistorico->listarTodos();
		}
	}
	
	protected function exportar() {
		$lHistorico = new HistoricoIptables();
		$lHistorico->ID = $_POST["ID"];
		$lDAOHistorico = new DAOHistoricoIptables($lHistorico);
		$lHistorico = $lDAOHistorico->buscarID();
		$lIptables = $lHistorico->Iptables;
		$lConfiguracion = $lIptables->generarXML();
		$lFile = new File("iptables.tmp","w",TMP);
		$lFile->escribirLineas($lConfiguracion);
		
		ob_end_clean();
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header('Content-disposition: attachment; filename='."iptables.rules");
		header("Content-Type: application/text");
		header("Content-Transfer-Encoding: binary");
		header('Content-Length: '. filesize(TMP."iptables.tmp"));
		
		readfile(TMP."iptables.tmp");
		exit;
	}
	
	protected function aplicar() {
		$lHistorico = new HistoricoIptables();
		$lHistorico->ID = $_POST["ID"];
		$lDAOHistorico = new DAOHistoricoIptables($lHistorico);
		$lHistorico = $lDAOHistorico->buscarID();
		
		$lFechaActivacion = new FechaActivacionIptables();
		$lDAOFechaActivacion = new DAOFechaActivacionIptables($lFechaActivacion);
		$lDAOFechaActivacion->agregar( $lHistorico->ID );
		
		$lIptables = $lHistorico->Iptables;
		$lIptables->Activo = true;
		$lDAOIptables = new DAOIptables($lIptables);
		$lDAOIptables->activar();
		
		$lConfiguracion = $lIptables->generarConfiguracion();
		$lFile = new File("iptables.tmp","w",TMP);
		$lFile->escribirLineas($lConfiguracion);
		
		exec("sudo cat ".TMP."iptables.tmp | sudo iptables-restore");
	}
	
	protected function eliminar() {
		try {
			// Se obtiene el Histórico según su ID
			$lHistorico = new HistoricoIptables();
			$lHistorico->ID = $_POST["ID"];
			$lDAOHistorico = new DAOHistoricoIptables($lHistorico);
			$lHistorico = $lDAOHistorico->buscarID();
			
			$lIptables = $lHistorico->Iptables;
			$lDAOIptables = new DAOIptables($lIptables);
			
			$lDAOFechaActivacion = new DAOFechaActivacionIptables();
			
			$lDAOReglaPredefinida = new DAOReglaPredefinidaIptables();
			
			$lDAOReglaIptables = new DAOReglaIptables();
			
			$lDAOReglaPredefinida->eliminarPorIptables($lIptables->ID);
			$lDAOReglaIptables->eliminarPorIptables($lIptables->ID);
			$lDAOIptables->eliminar();
			$lDAOFechaActivacion->eliminarPorHistorico($lHistorico->ID);
			$lDAOHistorico->eliminar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
}

?>