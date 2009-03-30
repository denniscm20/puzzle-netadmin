<?php
/**
 * @package /modulo/Snort/modelo/clases/
 * @class Snort
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once CLASES_SNORT.'Preprocesador.php';
require_once BASE.'IModulo.php';
require_once LIB.'helper.php';
require_once CLASES.'Interfaz.php';
require_once CLASES_SNORT.'Servicio.php';
require_once CLASES_SNORT.'ReglaPredefinida.php';
require_once CLASES_SNORT.'Libreria.php';


/**
 * class Snort
 * Esta clase representa las configuraciones básicas de la herramienta Snort.
 */
class Snort extends Clase implements IModulo {

	/** Aggregations: */

	private $aInterfazInterna = null;

	private $aInterfazExterna = null;

	private $aServicios = null;

	private $aPreprocesadores = null;

	private $aLibrerias = null;

	/** Compositions: */
	private $aReglasPredefinida = null;
	
	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aRutaReglas = "";

	/**
	 * @access private
	 */
	private $aRecursosLimitados = false;
	
	private $aActivo = false;

	public function __construct() {
		$this->aID = 0;
		$this->aRutaReglas = "";
		$this->aRecursosLimitados = false;
		$this->aInterfazInterna = array();
		$this->aInterfazExterna = array();
		$this->aActivo = false;
		$this->aServicios = array();
		$this->aPreprocesadores = array();
		$this->aLibrerias = array();
		$this->aReglasPredefinida = array();
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
	
	public function generarXML() {
		$lConfiguracion = array();

		array_push($lConfiguracion, "<?xml version='1.0' standalone='yes'?>");
		array_push($lConfiguracion, "<Modulo>");
		array_push($lConfiguracion, "<Snort>");
		array_push($lConfiguracion, "<RutaReglas>".$this->aRutaReglas."</RutaReglas>");
		array_push($lConfiguracion, "<RecursosLimitados>".$this->aRecursosLimitados."</RecursosLimitados>");
		array_push($lConfiguracion, "<InterfazInterna>");
		foreach ($this->aInterfazInterna as $lInterfaz)
			array_push($lConfiguracion, "<Interfaz>".$lInterfaz->ID."</Interfaz>");
		array_push($lConfiguracion, "</InterfazInterna>");
		array_push($lConfiguracion, "<InterfazExterna>");
		foreach ($this->aInterfazExterna as $lInterfaz)
			array_push($lConfiguracion, "<Interfaz>".$lInterfaz->ID."</Interfaz>");
		array_push($lConfiguracion, "</InterfazExterna>");
		array_push($lConfiguracion, "<Servicios>");
		foreach ($this->aServicios as $lServicio)
			$lConfiguracion = array_merge($lConfiguracion,$lServicio->generarXML());
		array_push($lConfiguracion, "</Servicios>");
		array_push($lConfiguracion, "<Preprocesadores>");
		foreach ($this->aPreprocesadores as $lPreprocesador)
			$lConfiguracion = array_merge($lConfiguracion,$lPreprocesador->generarXML());
		array_push($lConfiguracion, "</Preprocesadores>");
		array_push($lConfiguracion, "<Librerias>");
		foreach ($this->aLibrerias as $lLibreria)
			$lConfiguracion = array_merge($lConfiguracion,$lLibreria->generarXML());
		array_push($lConfiguracion, "</Librerias>");
		array_push($lConfiguracion, "<ReglasPredefinidas>");
		foreach ($this->aReglasPredefinida as $lRegla)
			$lConfiguracion = array_merge($lConfiguracion,$lRegla->generarXML());
		array_push($lConfiguracion, "</ReglasPredefinidas>");
		array_push($lConfiguracion, "</Snort>");
		array_push($lConfiguracion, "</Modulo>");
		
		return $lConfiguracion;
	} // end of member function estadoServicio

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function generarConfiguracion( ) {
		$lConfiguracion = array();
		array_push($lConfiguracion, "# Date: ".date("d-m-Y"));
		array_push($lConfiguracion, "# Network variables");
		
		$lVarHome = "";
		$lVarExternal = "";
		$lVarServicio = "";
		
		$lCount = count($this->aInterfazInterna);
		if ($lCount == 0) {
			$lVarHome = "any";
		} else {
			$lVarHome = "[";
			for ($i = 0; $i < $lCount; $i++) {
				$lInterfaz = $this->aInterfazInterna[$i];
				if ($i > 0) {
					$lVarHome .= ",";
				}
				$lVarHome .= $lInterfaz->IP."/".Helper::maskToShortMask($lInterfaz->Mascara);
			}
			$lVarHome .= "]";
		}
		array_push($lConfiguracion, "var HOME_NET ".$lVarHome);
		
		$lCount = count($this->aInterfazExterna);
		if ($lCount == 0) {
			$lVarExternal = "any";
		} else {
			$lVarExternal = "[";
			for ($i = 0; $i < $lCount; $i++) {
				$lInterfaz = $this->aInterfazExterna[$i];
				if ($i > 0) {
					$lVarExternal .= ",";
				}
				$lVarExternal .= "\$".$lInterfaz->Nombre."_ADDRESS";
			}
			$lVarExternal .= "]";
		}
		array_push($lConfiguracion, "var EXTERNAL_NET ".$lVarExternal);

		foreach ($this->aServicios as $lServicio) {
			$lVarServicio = "var ".$lServicio->TipoServicio->Nombre."_SERVERS ";
			$lCount = count ($lServicio->Nodos);
			if ($lCount == 0) {
				$lVarServicio .= "\$HOME_NET";
				array_push($lConfiguracion, "var ".$lVarServicio);
			} else {
				$lVarServicio .= "[";
				for ($i = 0; $i < $lCount; $i++) {
					$lNodo = $lServicio->Nodos[$i];
					if ($i > 0) {
						$lVarServicio .= ",";
					}
					$lVarServicio .= $lNodo->IP."/32";
				}
				$lVarServicio .= "]";
				array_push($lConfiguracion, "var ".$lVarServicio);
				
				$lPuertos = split(" ",$lServicio->Puertos);
				foreach ($lPuertos as $lPuerto) {
					if (trim($lPuerto) != "") {
						array_push($lConfiguracion, "var ".$lServicio->TipoServicio->Nombre."_PORTS ".$lPuerto);
					}
				}
			}
		}
		
		array_push($lConfiguracion, "var RULE_PATH ".$this->aRutaReglas);
		
		if ($this->aRecursosLimitados) {
			array_push($lConfiguracion, "config detection: search-method lowmem");
		}
		
		array_push($lConfiguracion, "# Dynamic loaded libraries");
		foreach ($this->aLibrerias as $lLibreria) {
			array_push($lConfiguracion, $lLibreria->TipoLibreria->Descripcion." ".$lLibreria->TipoValor->Descripcion." ".$lLibreria->Valor);
		}
		
		array_push($lConfiguracion, "# Preprocessor");
		foreach ($this->aPreprocesadores as $lPreprocesador) {
			$lTipoPreprocesador = $lPreprocesador->TipoPreprocesador;
			$lParametros = "";
			foreach ($lPreprocesador->Parametros as $lParametro) {
				$lParametros .= $lParametro->Nombre." ".$lParametro->Valor." ";
			}
			array_push($lConfiguracion, "preprocessor ".$lTipoPreprocesador->Nombre.": ".$lParametros);
		}
		
		array_push($lConfiguracion, "# Output Format");
		array_push($lConfiguracion, "include classification.config");
		array_push($lConfiguracion, "include reference.config");
		array_push($lConfiguracion, "# Rules");
		foreach ($this->aReglasPredefinida as $lRegla) {
			array_push($lConfiguracion, "include \$RULE_PATH/".$lRegla->Regla);
		}
		
		return $lConfiguracion;
	} // end of member function generarConfiguracion



} // end of Snort
?>
