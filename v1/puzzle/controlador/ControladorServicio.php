<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorServicio.php
 * @class controlador/ControladorServicio.php
 * @author dennis
 * @version 1.0
 */

require_once(BASE."Controlador.php");

/**
 * @class ControladorServicio
 * Controlador de la vista VistaServicio
 */
class ControladorServicio extends Controlador {

	 /*** Attributes: ***/

	/**
	 * Conjunto de Usuarios
	 * @access private
	 */
	private $aServicios = array();

	/**
	* Constructor de la clase
	*
	* @return 
	* @access private
	*/
	private function __construct( ) {
		$this->aServicios = array();
	} // end of member function __construct
	
	/**
	 * Obtiene una instancia de tipo ControladorUsuario
	 *
	 * @return controlador::ControladorUsuario
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorServicio();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function getServicios() {
		return $this->aServicios;
	}
	
	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "listar":
			case "iniciar":
			case "detener":
			case "reiniciar":
				$this->{$pEvento}();
				break;
		}
		
		$this->listar();
	}
	
	protected function verificarEstado($pServicio) {
		$lServicio = trim($pServicio);
		if ((strpos($lServicio, " ") === FALSE) && (file_exists("/etc/init.d/".$pServicio))) {
			exec("sudo /etc/init.d/".$lServicio." status | grep running", $lOutput);
			if (count($lOutput) == 1) {
				return array("En Ejecución",0);
			} else {
				return array("Detenido",1);
			}
		}
		else {
			return array("Nombre de servicio inválido",-1);
		}
	}
	
	protected function listar( ) {
		$lServicioList = $GLOBALS["lServicioList"];
		$this->aServicios = array();
		foreach ($lServicioList as $lServicio) {
			$lEstados = $this->verificarEstado($lServicio);
			$lLinea = array("Servicio"=>$lServicio, "EstadoServicio"=>$lEstados[0],"Iniciado"=>$lEstados[1]);
			$this->aServicios[] = $lLinea;
		}
	}
	
	protected function iniciar( ) {
		if (isset($_POST["Servicio"])) {
			$lServicioNum = $_POST["Servicio"];
			$this->aServicios = $GLOBALS["lServicioList"];
			$lCount = count($this->aServicios);
			for ($i = 0; $i < $lCount; $i++) {
				if ($i == $lServicioNum) {
					exec("sudo /etc/init.d/".$this->aServicios[$i]." start", $lOutput);
					break;
				}
			}
		} else {
		}
	}
	
	protected function detener( ) {
		if (isset($_POST["Servicio"])) {
			$lServicioNum = $_POST["Servicio"];
			$this->aServicios = $GLOBALS["lServicioList"];
			$lCount = count($this->aServicios);
			for ($i = 0; $i < $lCount; $i++) {
				if ($i == $lServicioNum) {
					exec("sudo /etc/init.d/".$this->aServicios[$i]." stop", $lOutput);
					break;
				}
			}
		} else {
		}
	}
	
	protected function reiniciar( ) {
		$this->detener();
		$this->iniciar();
	}

} // end of ControladorUsuario
?>
