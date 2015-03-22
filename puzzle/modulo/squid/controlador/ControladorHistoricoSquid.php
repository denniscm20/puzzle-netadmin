<?php

require_once BASE.'Controlador.php';
require_once LIB.'File.php';
require_once DAO_SQUID.'DAOHistoricoSquid.php';
require_once DAO_SQUID.'DAOFechaActivacionSquid.php';
require_once DAO_SQUID.'DAOSquid.php';
//require_once DAO_SQUID.'DAOReglaSquid.php';
//require_once DAO_SQUID.'DAOReglaPredefinida.php';

class ControladorHistoricoSquid extends Controlador {
	
	/*** Attributes: ***/

	/**
	 * @static
	 * @access private
	 */
	private $aHistoricosSquid = array();

	/**
	* Obtiene una instancia del objeto ControladorServidor
	*
	* @return controlador::ControladorServidor
	* @static
	* @access public
	*/
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorHistoricoSquid();
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
	
	public function getHistoricosSquid() {
		return $this->aHistoricosSquid;
	}
	
	protected function buscar () {
		$lDAOHistorico = new DAOHistoricoSquid();
		if (isset($_POST["txtFechaInicio"]) or isset($_POST["txtFechaFin"])) {
			$lFechaInicio = (trim($_POST["txtFechaInicio"]) != "")?date("Ymd",strtotime(trim($_POST["txtFechaInicio"]))):"00000000";
			$lFechaFin = (trim($_POST["txtFechaFin"]) != "")?date("Ymd",strtotime(trim($_POST["txtFechaFin"]))):date("Ymd");
			
			$this->aHistoricosSquid = $lDAOHistorico->listarPorFecha($lFechaInicio, $lFechaFin);
		} else {
			$this->aHistoricosSquid = $lDAOHistorico->listarTodos();
		}
	}
	
	protected function exportar() {
		$lHistorico = new HistoricoSquid();
		$lHistorico->ID = $_POST["ID"];
		$lDAOHistorico = new DAOHistoricoSquid($lHistorico);
		$lHistorico = $lDAOHistorico->buscarID();
		
		$lSquid = $lHistorico->Squid;
		$lConfiguracion = $lSquid->generarXML();
		$lFile = new File("squid.tmp","w",TMP);
		$lFile->escribirLineas($lConfiguracion);
		
		ob_end_clean();
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header('Content-disposition: attachment; filename='."squid.rules");
		header("Content-Type: application/text");
		header("Content-Transfer-Encoding: binary");
		header('Content-Length: '. filesize(TMP."squid.tmp"));
		readfile(TMP."squid.tmp");
		
		exit;
	}
	
	protected function aplicar() {
		$lHistorico = new HistoricoSquid();
		$lHistorico->ID = $_POST["ID"];
		$lDAOHistorico = new DAOHistoricoSquid($lHistorico);
		$lHistorico = $lDAOHistorico->buscarID();
		
		$lFechaActivacion = new FechaActivacionSquid();
		$lDAOFechaActivacion = new DAOFechaActivacionSquid($lFechaActivacion);
		$lDAOFechaActivacion->agregar( $lHistorico->ID );
		
		$lSquid = $lHistorico->Squid;
		$lSquid->Activo = true;
		$lDAOSquid = new DAOSquid($lSquid);
		$lDAOSquid->activar();
		
		$lConfiguracion = $lSquid->generarConfiguracion();
		$lFile = new File("squid.tmp","w",TMP);
		$lFile->escribirLineas($lConfiguracion);
		
		exec("cat ".TMP."squid.tmp | sudo /usr/bin/tee /etc/squid/squid.conf");
		exec("sudo /etc/init.d/squid stop");
		exec("sudo /usr/sbin/squid -z");
		exec("sudo /etc/init.d/squid start");
	}
	
	protected function eliminar() {
		try {
			// Se obtiene el Histórico según su ID
			$lHistorico = new HistoricoSquid();
			$lHistorico->ID = $_POST["ID"];
			$lDAOHistorico = new DAOHistoricoSquid($lHistorico);
			$lHistorico = $lDAOHistorico->buscarID();
			
			$lSquid = $lHistorico->Squid;
			$lDAOSquid = new DAOSquid($lSquid);
			
			$lDAOFechaActivacion = new DAOFechaActivacionSquid();
			$lDAOReglaPredefinida = new DAOReglaPredefinida();
			$lDAOReglaSquid = new DAOReglaSquid();
			$lDAOPuertoSquid = new DAOPuertoSquid();
			$lDAOValor = new DAOValor();
			
			$lDAOListaControlAcceso = new DAOListaControlAcceso();
			$lACLs = $lDAOListaControlAcceso->buscarSquid($lSquid->ID);
			foreach ($lACLs as $lACL) {
				$lDAOValor->eliminarPorListaControlAcceso($lACL->ID);
				$lDAOListaControlAcceso = new DAOListaControlAcceso($lACL);
				$lDAOListaControlAcceso->eliminar();
			}

			$lDAOPuertoSquid->eliminarPorSquid($lSquid->ID);
			$lDAOReglaPredefinida->eliminarPorSquid($lSquid->ID);
			$lDAOReglaSquid->eliminarPorSquid($lSquid->ID);
			$lDAOSquid->eliminar();
			$lDAOFechaActivacion->eliminarPorHistorico($lHistorico->ID);
			$lDAOHistorico->eliminar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
}

?>