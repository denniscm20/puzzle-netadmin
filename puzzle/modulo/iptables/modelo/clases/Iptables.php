<?php
/**
 * @package /home/dennis/uml-generated-code/modulo/Iptables/modelo/clases/Iptables.php
 * @class modulo/Iptables/modelo/clases/Iptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once BASE.'IModulo.php';
require_once CLASES_IPTABLES.'Table.php';
require_once CLASES_IPTABLES.'ReglaPredefinida.php';

/**
 * class Iptables
 * Esta clase representa las configuraciones básicas de la herramienta Iptables.
 */
class Iptables extends Clase implements IModulo {

	/*** Attributes: ***/
	private $aTablas = null;
	
	private $aDescripcion = "";
	
	private $aActivo = false;
	
	private $aReglasPredefinidas = array();

	public function __construct() {
		$this->aTablas = array();
		$this->aDescripcion = "";
		$this->aActivo = false;
		$this->aReglasPredefinidas = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<?xml version='1.0' standalone='yes'?>");
		array_push($lConfiguracion, "<Modulo>");
		array_push($lConfiguracion, "<Iptables>");
		array_push($lConfiguracion, "<Tablas>");
		foreach ($this->aTablas as $lTabla)
			$lConfiguracion = array_merge($lConfiguracion,$lTabla->generarXML());
		array_push($lConfiguracion, "</Tablas>");
		array_push($lConfiguracion, "<Descripcion>".$this->aDescripcion."</Descripcion>");
		array_push($lConfiguracion, "<ReglasPredefinidas>");
		foreach ($this->aReglasPredefinidas as $lReglaPredefinida)
			$lConfiguracion = array_merge($lConfiguracion,$lReglaPredefinida->generarXML());
		array_push($lConfiguracion, "</ReglasPredefinidas>");
		array_push($lConfiguracion, "</Iptables>");
		array_push($lConfiguracion, "</Modulo>");
		
		return $lConfiguracion;
	}
	
	public function generarConfiguracion() {
		$lConfiguracion = array();
		foreach($this->aTablas as $lTabla) {
			array_push($lConfiguracion, "*".strtolower($lTabla->Nombre));

			foreach ($lTabla->Cadenas as $lCadena) {
				array_push($lConfiguracion, ":".strtoupper($lCadena->Nombre)." ".$lCadena->Politica->Nombre." [0:0]");
			}
			
			/* Reglas Predefinidas */
			if ($lTabla->Nombre == "Filter") {
				foreach($this->aReglasPredefinidas as $lReglaPredefinida) {
					foreach($lReglaPredefinida->DetalleReglaPredefinida as $lDetalleReglaPredefinida) {
						$lLinea = $lDetalleReglaPredefinida->Regla." -j ".$lReglaPredefinida->Accion->Nombre;
						$lConfiguracion[] = $lLinea;
					}
				}
			}
					
			/* Reglas */
			foreach ($lTabla->Cadenas as $lCadena) {
				foreach($lCadena->ReglasIptables as $lReglaIptables) {
					$lComplementoaccionNat = "";
					
					$lLinea = "-A ".$lCadena->Nombre;
					
					if ($lReglaIptables->Protocolo->Nombre != "")
						$lLinea .= " -p ".$lReglaIptables->Protocolo->Nombre;
					
					switch ($lCadena->Nombre) {
						case "INPUT":
						case "FORWARD":
						case "PREROUTING":
							if ($lReglaIptables->InterfazOrigen->ID != 0)
								$lLinea .= " -i ".$lReglaIptables->InterfazOrigen->Nombre;
							break;
						case "OUTPUT":
						case "FORWARD":
						case "POSTROUTING":
							if ($lReglaIptables->InterfazDestino->ID != 0) 
								$lLinea .= " -o ".$lReglaIptables->InterfazDestino->Nombre;
							break;
					}
					
					switch ($lTabla->Nombre) {
						case "NAT":
							switch ($lReglaIptables->Accion->Nombre) {
								case "MASQUERADE":
									break;
								case "SNAT":
									if ($lReglaIptables->IPOrigen != "") {
										$lLinea .= " --dst ".$lReglaIptables->IPOrigen;
										$lLinea .= ($lReglaIptables->MascaraOrigen != "")?"/".$lReglaIptables->MascaraOrigen:"";
									}
					
									if ($lReglaIptables->PuertoOrigenInicial != "") {
										$lLinea .= " --dport ".$lReglaIptables->PuertoOrigenInicial;
										$lLinea .= ($lReglaIptables->PuertoOrigenFinal != "")?":".$lReglaIptables->PuertoOrigenFinal:"";
									}
							
									if ($lReglaIptables->IPDestino != "") { 
										$lComplementoaccionNat .= " --to-source ".$lReglaIptables->IPDestino;
										if ($lReglaIptables->PuertoDestinoInicial != "") {
											$lComplementoaccionNat .= ":".$lReglaIptables->PuertoDestinoInicial;
											$lComplementoaccionNat .= ($lReglaIptables->PuertoDestinoFinal != "")?"-".$lReglaIptables->PuertoDestinoFinal:"";
										}
									}
									break;
								case "DNAT":
									if ($lReglaIptables->IPOrigen != "") {
										$lLinea .= " --dst ".$lReglaIptables->IPOrigen;
										$lLinea .= ($lReglaIptables->MascaraOrigen != "")?"/".$lReglaIptables->MascaraOrigen:"";
									}
					
									if ($lReglaIptables->PuertoOrigenInicial != "") {
										$lLinea .= " --dport ".$lReglaIptables->PuertoOrigenInicial;
										$lLinea .= ($lReglaIptables->PuertoOrigenFinal != "")?":".$lReglaIptables->PuertoOrigenFinal:"";
									}
							
									if ($lReglaIptables->IPDestino != "") { 
										$lComplementoaccionNat .= " --to-destination ".$lReglaIptables->IPDestino;
										if ($lReglaIptables->PuertoDestinoInicial != "") {
											$lComplementoaccionNat .= ":".$lReglaIptables->PuertoDestinoInicial;
											$lComplementoaccionNat .= ($lReglaIptables->PuertoDestinoFinal != "")?"-".$lReglaIptables->PuertoDestinoFinal:"";
										}
									}
									break;
								case "REDIRECT":
									if ($lReglaIptables->PuertoOrigenInicial != "") {
										$lLinea .= " --dport ".$lReglaIptables->PuertoOrigenInicial;
										$lLinea .= ($lReglaIptables->PuertoOrigenFinal != "")?":".$lReglaIptables->PuertoOrigenFinal:"";
									}
									
									if ($lReglaIptables->PuertoDestinoInicial != "") {
										$lComplementoaccionNat .= " --to-ports ".$lReglaIptables->PuertoDestinoInicial;
										$lComplementoaccionNat .= ($lReglaIptables->PuertoDestinoFinal != "")?"-".$lReglaIptables->PuertoDestinoFinal:"";
									}
									break;
							}
							break;
						case "Filter":
						default:
							if ($lReglaIptables->IPOrigen != "") {
								$lLinea .= " --src ".$lReglaIptables->IPOrigen;
								$lLinea .= ($lReglaIptables->MascaraOrigen != "")?"/".$lReglaIptables->MascaraOrigen:"";
							}
					
							if ($lReglaIptables->PuertoOrigenInicial != "" && $lReglaIptables->Protocolo->Nombre != "") {
								$lLinea .= " --sport ".$lReglaIptables->PuertoOrigenInicial;
								$lLinea .= ($lReglaIptables->PuertoOrigenFinal != "")?":".$lReglaIptables->PuertoOrigenFinal:"";
							}
							
							if ($lReglaIptables->IPDestino != "") { 
								$lLinea .= " --dst ".$lReglaIptables->IPDestino;
								$lLinea .= ($lReglaIptables->MascaraDestino != "")?"/".$lReglaIptables->MascaraDestino:"";
							}
							
							if ($lReglaIptables->PuertoDestinoInicial != "" && $lReglaIptables->Protocolo->Nombre != "") {
								$lLinea .= " --dport ".$lReglaIptables->PuertoDestinoInicial;
								$lLinea .= ($lReglaIptables->PuertoDestinoFinal != "")?":".$lReglaIptables->PuertoDestinoFinal:"";
							}
							
							// El -m tcp bota errores en algunos casos en PCLinuxOS
							
							if ($lReglaIptables->MAC != "")
								$lLinea .= " -m mac --mac-source ".$lReglaIptables->MAC;
			
							if ($lReglaIptables->Estado->Nombre != "")
								$lLinea .= " -m state --state ".$lReglaIptables->Estado->Nombre;
							
							break;
					}
					
					$lLinea .= " -j ".$lReglaIptables->Accion->Nombre.$lComplementoaccionNat;
					array_push($lConfiguracion, $lLinea);
				}
			}
			array_push($lConfiguracion, "COMMIT");
		}
		return $lConfiguracion;
	}

	public function __get($pAtributo) {
		$lAtributo = "a".$pAtributo;
		if (isset($this->{$lAtributo})) {
			return $this->{$lAtributo};
		} 
		return $pAtributo;
	}
	
	public function __set($pAtributo, $pValor) {
		$lAtributo = "a".$pAtributo;
		if (isset($this->{$lAtributo})) {
			$this->{$lAtributo} = $pValor;
		}
		return $pAtributo;
	}

} // end of Iptables

?>
