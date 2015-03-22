<?php

require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'ReglaPredefinida.php';

class Categoria extends Clase {
	
	private $aNombre;
	private $aReglasPredefinidas = array();
	
	public function __construct($pNombre = "") {
		$this->aID = 0;
		$this->aNombre = $pNombre;
		$this->aReglasPredefinidas = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<Categoria>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		array_push($lConfiguracion, "<ReglasPredefinidas>");
		foreach ($this->aReglasPredefinidas as $lReglaPredefinida)
			$lConfiguracion = array_merge($lConfiguracion, $lReglaPredefinida->generarXML());
		array_push($lConfiguracion, "</ReglasPredefinidas>");
		array_push($lConfiguracion, "</Categoria>");
		return $lConfiguracion;
	}
	
	public function __get($pAtributo) {
		$lAtributo = "a".$pAtributo;
		if (isset($this->{$lAtributo})){
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
	
}

?>