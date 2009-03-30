<?php

abstract class Controlador {
	
	/**
	* @static
	* @access protected
	*/
	protected static $aControlador;
	
	/**
	* Obtiene una instancia del objeto Controlador
	*
	* @return controlador::Controlador
	* @static
	* @access public
	*/
	public abstract static function obtenerInstancia( );
	
	public abstract function procesar($pEvento = "");
}

?>