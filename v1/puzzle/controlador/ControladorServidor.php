<?php
/**
 * @package /controlador/
 * @class ControladorServidor
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once CLASES.'Servidor.php';
require_once CLASES.'IPv4Valida.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'Subred.php';
require_once DAO.'DAOServidor.php';
require_once DAO.'DAOSubred.php';
require_once DAO.'DAOInterfaz.php';
require_once DAO.'DAONodo.php';
require_once DAO.'DAOIPv4Valida.php';
require_once LIB.'validator.php';
require_once BASE.'Controlador.php';

/**
 * @class ControladorServidor
 * Controlador de la pantalla VistaServidor
 */
class ControladorServidor extends Controlador {

	/*** Attributes: ***/

	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorServidor();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		switch ($pEvento) {
			case "agregarIP":
			case "habilitar":
			case "recargar":
			case "eliminarIP":
				$this->{$pEvento}();
				break;
		}
		
		$this->buscarID();
	}
	
	/**
	 * Permite guardar las configuraciones del servidor.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregarIP( ) {
		try {
			$lIPv4Valida = new IPv4Valida();
			$lIPv4Valida->IP = $_POST['txtNuevoIP'];
			if (Validator::validarIp4($lIPv4Valida->IP)) {
				$lDAOIPv4Valida = new DAOIPv4Valida($lIPv4Valida);
				return $lDAOIPv4Valida->agregar($_POST['ServidorID']);
			} else {
				throw new Exception("El valor ingresado no tiene un formato de dirección IP");
			}
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function agregarIP
	
	public function habilitar( ) {
		try {
			$lServidor = new Servidor();
			$lServidor->ID = 1;
			$lValor = exec("cat /proc/sys/net/ipv4/ip_forward");
			if ($lValor) {
				exec("echo 0 | sudo /usr/bin/tee /proc/sys/net/ipv4/ip_forward");
			} else {
				exec("echo 1 | sudo /usr/bin/tee /proc/sys/net/ipv4/ip_forward");
			}
			
			$lDAOServidor = new DAOServidor($lServidor);
			$lServidor = $lDAOServidor->buscarID();
			$lServidor->Reenvio = exec("cat /proc/sys/net/ipv4/ip_forward");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	/**
	 * Permite actualizar los valores del servidor.
	 *
	 * @return bool
	 * @access public
	 */
	public function recargar( ) {
		$lServidor = new Servidor();
		$lServidor->ID = 1;
		
		// Obtener Nombre del Host
		$lServidor->Hostname = exec("hostname");
		
		//Obtener Gateway
		$lServidor->Gateway = exec("ip route | grep default | cut -d' ' -f3");
		
		// Obtener DNS
		$lServidor->DNS1 = exec("cat /etc/resolv.conf | grep nameserver | cut -d' ' -f2 | head -n 1");
		$lServidor->DNS2 = exec("cat /etc/resolv.conf | grep nameserver | cut -d' ' -f2 | tail -n 1");
		
		// Obtener datos del ifconfig
		$lSalida;
		$lInterfaces = array();

		exec("/sbin/ifconfig",$lSalida);
		$lCount = 0;

		$lInterfaz = new Interfaz();
		foreach ($lSalida as $lLinea) {
			if (trim($lLinea) != "") {
				switch ($lCount) {
					case 0:
						$lInterfaz->Nombre = substr($lLinea,0,strpos($lLinea,' '));
						$lInicio = strpos($lLinea,'HWaddr');
						if ($lInicio) {
							$lInterfaz->MAC = substr($lLinea,$lInicio + strlen('HWaddr '));
						}
						break;
					case 1:
						$lInicio =  strpos($lLinea,'inet addr:');
						$lOffset = strlen('inet addr:');
						$lFin = strpos ($lLinea,'Bcast') - 2;
						if ($lFin < 0) {
							$lFin = strpos($lLinea,'Mask') - 2;
						}
						if ($lInicio) {
							$lInterfaz->IP = substr($lLinea,$lInicio + $lOffset, $lFin - $lInicio - $lOffset);
						}
						$lInicio =  strpos($lLinea,'Mask:');
						$lOffset = strlen('Mask:');
						$lInterfaz->Mascara = substr($lLinea,$lInicio + $lOffset);
						break;
					case 2: break;
					default: continue;
				}
				$lCount++;
			} else {
				$lCount = 0;
				$lInterfaces[] = $lInterfaz;
				$lInterfaz = new Interfaz();
			}
		}
		$lServidor->Interfaces = $lInterfaces;
		
		// Obtener los datos del ipv4_forward
		$lServidor->Reenvio = exec("cat /proc/sys/net/ipv4/ip_forward");

		try {
			$lDAOServidor = new DAOServidor($lServidor);
			$lDAOInterfaz = new DAOInterfaz(null);
			$lDAOInterfaz->eliminarPorServidor($lServidor->ID);
			$lInterfaces = $lServidor->Interfaces;
			foreach ($lInterfaces as $lInterfaz) {
				$lDAOInterfaz = new DAOInterfaz($lInterfaz);
				$lDAOInterfaz->agregar($lServidor->ID);
			}
			
			$lDAOSubred = new DAOSubred(null);
			$lSubredes = $lDAOSubred->listarTodos();
			foreach ($lSubredes as $lSubred) {
				$lDAOSubred = new DAOSubred($lSubred);
				$lIP = $lSubred->IP;
				$lMascara = $lSubred->Mascara;
				$lSubIP = explode(".",$lIP);
				$lSubMascara = explode(".",$lMascara);
				$lCount = count($lSubIP);
				$lIP = "";
				for ($i = 0; $i < $lCount; $i++) {
					$lM = 0 + $lMascara[$i];
					if ($lM == 0) {
						break;
					} else {
						$lIP .= $lSubIP[$i].".";
					}
				}
				$lDAOSubred->recargarInterfaz($lIP);
			}
			
			return $lDAOServidor->modificar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function guardar

	/**
	 * Permite eliminar una dirección IP.
	 *
	 * @return bool
	 * @access public
	*/
	public function eliminarIP( ) {
		try {
			$lIPv4Valida = new IPv4Valida();
			$lIPv4Valida->ID = $_POST['IPValidaID'];
			$lDAOIPv4Valida = new DAOIPv4Valida($lIPv4Valida);
			return $lDAOIPv4Valida->eliminar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function eliminar

	/**
	 * Permite buscar la información de un servidor de acuerdo a su ID.
	 *
	 * @return 
	 * @access public
	 */
	public function buscarID( ) {
		try {
			$lServidor = new Servidor();
			$lServidor->ID = 1;
			$lDAOServidor = new DAOServidor($lServidor);
			$lServidor = $lDAOServidor->buscarID();

			$lServidor->Reenvio = exec("cat /proc/sys/net/ipv4/ip_forward");
			return $lServidor;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function buscarID


	/**
	 * Contructor del objeto ControladorServidor
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		
	} // end of member function __construct

} // end of ControladorServidor
?>
