<?php

require_once BASE.'Controlador.php';
require_once LIB.'File.php';
require_once DAO_SNORT.'DAOHistoricoSnort.php';
require_once DAO_SNORT.'DAOFechaActivacionSnort.php';
require_once DAO_SNORT.'DAOSnort.php';

class ControladorHistoricoSnort extends Controlador {
	
	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private $aHistoricosSnort = array();

	/**
	* Obtiene una instancia del objeto ControladorServidor
	*
	* @return controlador::ControladorServidor
	* @static
	* @access public
	*/
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorHistoricoSnort();
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
	
	public function getHistoricosSnort() {
		return $this->aHistoricosSnort;
	}
	
	protected function buscar () {
		$lDAOHistorico = new DAOHistoricoSnort();
		if (isset($_POST["txtFechaInicio"]) or isset($_POST["txtFechaFin"])) {
			$lFechaInicio = (trim($_POST["txtFechaInicio"]) != "")?date("Ymd",strtotime(trim($_POST["txtFechaInicio"]))):"00000000";
			$lFechaFin = (trim($_POST["txtFechaFin"]) != "")?date("Ymd",strtotime(trim($_POST["txtFechaFin"]))):date("Ymd");
			
			$this->aHistoricosSnort = $lDAOHistorico->listarPorFecha($lFechaInicio, $lFechaFin);
		} else {
			$this->aHistoricosSnort = $lDAOHistorico->listarTodos();
		}
	}
	
	protected function exportar() {
		$lHistorico = new HistoricoSnort();
		$lHistorico->ID = $_POST["ID"];
		$lDAOHistorico = new DAOHistoricoSnort($lHistorico);
		$lHistorico = $lDAOHistorico->buscarID();
		
		$lSnort = $lHistorico->Snort;
		$lConfiguracion = $lSnort->generarXML();
		$lFile = new File("snort.tmp","w",TMP);
		$lFile->escribirLineas($lConfiguracion);
		
		ob_end_clean();
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header('Content-disposition: attachment; filename='."snort.rules");
		header("Content-Type: application/text");
		header("Content-Transfer-Encoding: binary");
		header('Content-Length: '. filesize(TMP."snort.tmp"));
		
		readfile(TMP."snort.tmp");
		
		exit;
	}
	
	protected function aplicar() {
		$lHistorico = new HistoricoSnort();
		$lHistorico->ID = $_POST["ID"];
		$lDAOHistorico = new DAOHistoricoSnort($lHistorico);
		$lHistorico = $lDAOHistorico->buscarID();
		
		$lFechaActivacion = new FechaAplicacionSnort();
		$lDAOFechaActivacion = new DAOFechaActivacionSnort($lFechaActivacion);
		$lDAOFechaActivacion->agregar( $lHistorico->ID );
		
		$lSnort = $lHistorico->Snort;
		$lSnort->Activo = true;
		$lDAOSnort = new DAOSnort($lSnort);
		$lDAOSnort->activar();
		
		$lConfiguracion = $lSnort->generarConfiguracion();
		$lFile = new File("snort.tmp","w",TMP);
		$lFile->escribirLineas($lConfiguracion);
		
		exec("cat ".TMP."snort.tmp | sudo /usr/bin/tee /etc/snort/snort.conf");
		exec("sudo /etc/init.d/snort stop");
		exec("sudo /usr/sbin/snort -z");
		exec("sudo /etc/init.d/snort start");
	}
	
	protected function eliminar() {
		try {
			// Se obtiene el Histórico según su ID
			$lHistorico = new HistoricoSnort();
			$lHistorico->ID = $_POST["ID"];
			$lDAOHistorico = new DAOHistoricoSnort($lHistorico);
			$lHistorico = $lDAOHistorico->buscarID();
			
			$lSnort = $lHistorico->Snort;
			$lDAOSnort = new DAOSnort($lSnort);
			
			$lDAOFechaActivacion = new DAOFechaActivacionSnort();
			$lDAOReglaPredefinida = new DAOReglaPredefinida();
			$lDAOServicio = new DAOServicio();
			$lDAOLibreria = new DAOLibreria();
			$lDAOPreprocesador = new DAOPreprocesador();
			
			$lDAOServicio->eliminarSnort($lSnort->ID);
			$lDAOLibreria->eliminarSnort($lSnort->ID);
			$lDAOPreprocesador->eliminarSnort($lSnort->ID);
			$lDAOReglaPredefinida->eliminarPorSnort($lSnort->ID);
			$lDAOSnort->eliminar();
			$lDAOFechaActivacion->eliminarPorHistorico($lHistorico->ID);
			$lDAOHistorico->eliminar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
}

?>