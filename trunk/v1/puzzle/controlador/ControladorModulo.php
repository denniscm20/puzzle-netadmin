<?php
/**
 * @package /home/dennis/uml-generated-code/controlador/ControladorModulo.php
 * @class controlador/ControladorModulo.php
 * @author dennis
 * @version 1.0
 */

require_once(BASE."Controlador.php");

/**
 * @class ControladorModulo
 * Controlador de la vista VistaModulo
 */
class ControladorModulo extends Controlador {

	 /*** Attributes: ***/

	/**
	 * Conjunto de Usuarios
	 * @access private
	 */
	private $aModulos = array();

	/**
	* Constructor de la clase
	*
	* @return 
	* @access private
	*/
	private function __construct( ) {
		$this->aModulos = array();
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
			self::$aControlador = new ControladorModulo();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function getModulos() {
		return $this->aModulos;
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
	
	protected function verificarInstalacion( $pModulo ) {
		$lModulo = trim($pModulo);
		if (strpos($lModulo, " ") === FALSE) {
			exec("rpm -q ".$lModulo." | grep 'not installed'", $lOutput);
			if (count($lOutput) == 0) {
				return "Instalado";
			} else {
				return "No Instalado";
			}
		}
		else 
			return "Nombre de paquete inválido";
	}
	
	protected function verificarModulo( $pModulo ) {
		$lModulo = trim($pModulo);
		if (strpos($lModulo, " ") === FALSE) {
			if (file_exists(MODULO.$lModulo)) {
				return "Instalado";
			} else {
				return "No Instalado";
			}
		}
		else 
			return "Nombre de paquete inválido";
	}
	
	protected function listar( ) {
		$lModuloList = $GLOBALS["lModuloList"];
		foreach ($lModuloList as $lModulo) {
			$lLinea = array("Modulo"=>$lModulo, "EstadoAplicacion"=>$this->verificarInstalacion($lModulo), "EstadoModulo"=>$this->verificarModulo($lModulo));
			$this->aModulos[] = $lLinea;
		}
	}

} // end of ControladorUsuario
?>
