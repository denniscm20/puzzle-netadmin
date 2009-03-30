<?php
/**
 * @package /controlador/
 * @class ControladorRegistroHistorico
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once CLASES.'RegistroHistorico.php';
require_once DAO.'DAORegistroHistorico.php';

/**
 * @class ControladorRegistroHistorico
 * Controlador de la pantalla VistaRegistroHistorico
 */
class ControladorRegistroHistorico extends Controlador {

	private $aRegistrosHistoricos = null;
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorRegistroHistorico();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		$this->cargarReferencias();
		switch ($pEvento) {
			case "buscar":
				$this->{$pEvento}();
				break;
		}
	}
	
	public function getRegistrosHistoricos() {
		return $this->aRegistrosHistoricos;
	}
	
	protected function buscar() {
		try {
			$lCriterio = isset($_GET["Criterio"])?$_GET["Criterio"]:"";
			switch ($lCriterio) {
				case "":
					$lUltimos = (isset($_POST["txtUltimos"]) && ($_POST["txtUltimos"] > 0))?$_POST["txtUltimos"]:10;
					$lDAORegistroHistorico = new DAORegistroHistorico();
					$this->aRegistrosHistoricos = $lDAORegistroHistorico->listarUltimos($lUltimos);
					break;
				case "Fecha":
					$lFechaInicio = isset($_POST["txtFechaInicio"])?date("Ymd",strtotime($_POST["txtFechaInicio"])):"";
					$lFechaFin = isset($_POST["txtFechaFin"])?date("Ymd",strtotime($_POST["txtFechaFin"])):"";
					$lDAORegistroHistorico = new DAORegistroHistorico();
					$this->aRegistrosHistoricos = $lDAORegistroHistorico->buscarPorFecha($lFechaInicio, $lFechaFin);
					break;
				case "Usuario":
					$lRegistroHistorico = new RegistroHistorico();
					$lRegistroHistorico->Usuario = $_POST["txtUsuario"];
					$lDAORegistroHistorico = new DAORegistroHistorico($lRegistroHistorico);
					$this->aRegistrosHistoricos = $lDAORegistroHistorico->buscarPorUsuario();
					break;
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function cargarReferencias( ) {
		try {
			$lDAORegistroHistorico = new DAORegistroHistorico();
			$this->aRegistrosHistoricos = $lDAORegistroHistorico->listarUltimos();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	/**
	 * Contructor del objeto ControladorServidor
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		$this->aRegistrosHistoricos = array();
	} // end of member function __construct

} // end of ControladorServidor
?>
