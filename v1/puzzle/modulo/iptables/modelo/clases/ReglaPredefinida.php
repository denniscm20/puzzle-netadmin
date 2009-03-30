<?php

require_once BASE.'Clase.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once CLASES_IPTABLES.'DetalleReglaPredefinida.php';

class ReglaPredefinidaIptables extends Clase {
	
	private $aNombre;
	private $aAccion = null;
	private $aDetalleReglaPredefinida = null;
	
	public function __construct ($pNombre = "") {
		$this->aID = 0;
		$this->aNombre = $pNombre;
		$this->aAccion = new AccionIptables();
		$this->aDetalleReglaPredefinida = array();
	}
	
	public function generarXML() {
		$lConfiguracion = array();

		array_push($lConfiguracion, "<ReglaPredefinida>");
		array_push($lConfiguracion, "<ID>".$this->aID."</ID>");
		array_push($lConfiguracion, "<Nombre>".$this->aNombre."</Nombre>");
		$lConfiguracion = array_unique(array_merge($lConfiguracion, $this->aAccion->generarXML()));
		array_push($lConfiguracion, "<DetallesReglaPredefinida>");
		foreach ($this->aDetalleReglaPredefinida as $lDetalle)
			$lConfiguracion = array_unique(array_merge($lConfiguracion, $lDetalle->generarXML()));
		array_push($lConfiguracion, "</DetallesReglaPredefinida>");
		array_push($lConfiguracion, "</ReglaPredefinida>");
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
	
}

?>