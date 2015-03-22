<?php
/**
 * @package /home/dennis/uml-generated-code/modelo/dao/DAORegistroHistorico.php
 * @class modelo/dao/DAORegistroHistorico.php
 * @author dennis
 * @version 1.0
 */

require_once CLASES.'RegistroHistorico.php';
require_once BASE.'DAO.php';


/**
 * class DAORegistroHistorico
 */
class DAORegistroHistorico extends DAO {

	 /**
	 * Constructor de la clase
	 * @param modelo::clases::RegistroHistorico pRegistroHistorico 
	 * @return 
	 * @access public
	 */
	public function __construct( $pRegistroHistorico = null ) {
		parent::__construct($pRegistroHistorico);
	} // end of member function __construct

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {
		parent::__destruct();
	} // end of member function __destruct

	/**
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$this->aQuery = "INSERT INTO RegistroHistorico (Fecha, Hora, Browser, Usuario, IP, Mensaje) VALUES (?,?,?,?,?,?)";
			$this->aParameters = array($this->aObjeto->Fecha, $this->aObjeto->Hora, $this->aObjeto->Browser, $this->aObjeto->Usuario, $this->aObjeto->IP, $this->aObjeto->Mensaje);
			$lResultado = $this->insert();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregarRegistroHistorico

	/**
	 *
	 * @return bool
	 * @access public
	 */
	public function eliminar( ) {
		try {
			$this->aQuery = "DELETE FROM RegistroHistorico WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->ID);
			$lResultado = $this->delete();
			return $lResultado;
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function eliminarRegistroHistorico

	/**
	 *
	 * @return array
	 * @access public
	 */
	public function buscarPorFecha( $pFechaInicio, $pFechaFin ) {
		try {
			$this->aQuery = "SELECT * FROM RegistroHistorico WHERE Fecha >= ? AND Fecha <= ? ORDER BY Fecha DESC, Hora DESC";
			$this->aParameters = array($pFechaInicio, $pFechaFin);
			$lResultado = $this->select();
			
			$lRegistroHistoricos = array();
			foreach ($lResultado as $lElemento) {
				$lRegistroHistoricos[] = $this->cargarObjeto($lElemento);
			}
			return $lRegistroHistoricos;
		} catch (Exception $e) {
			throw $e;
		}
		
	} // end of member function buscarRegistroHistorico
			
	/**
	 *
	 * @return array
	 * @access public
	 */
	public function buscarPorUsuario( ) {
		try {
			$this->aQuery = "SELECT * FROM RegistroHistorico WHERE Usuario = ? ORDER BY Fecha DESC, Hora DESC";
			$this->aParameters = array($this->aObjeto->Usuario);
			$lResultado = $this->select();
			
			$lRegistroHistoricos = array();
			foreach ($lResultado as $lElemento) {
				$lRegistroHistoricos[] = $this->cargarObjeto($lElemento);
			}
			
			return $lRegistroHistoricos;
		} catch (Exception $e) {
			throw $e;
		}
		
	} // end of member function buscarRegistroHistorico

	/**
	 * Lista todos los usuarios registrados en la aplicación.
	 *
	 * @return array
	 * @access public
	 */
	public function listarUltimos($pUltimos = 10) {
		try {
			$this->aQuery = "SELECT * FROM RegistroHistorico ORDER BY Fecha DESC, Hora DESC LIMIT ?";
			$this->aParameters = array($pUltimos);
			$lResultado = $this->select();
			
			$lRegistroHistoricos = array();
			foreach ($lResultado as $lElemento) {
				$lRegistroHistoricos[] = $this->cargarObjeto($lElemento);
			}
			
			return $lRegistroHistoricos;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	protected function cargarObjeto($lElemento) {
		$lRegistroHistorico = new RegistroHistorico();
		$lRegistroHistorico->ID = $lElemento['ID'];
		$lRegistroHistorico->Fecha = $lElemento['Fecha'];
		$lRegistroHistorico->Hora = $lElemento['Hora'];
		$lRegistroHistorico->Usuario = $lElemento['Usuario'];
		$lRegistroHistorico->Mensaje = $lElemento['Mensaje'];
		$lRegistroHistorico->IP = $lElemento['IP'];
		$lRegistroHistorico->Browser = $lElemento['Browser'];

		return $lRegistroHistorico;
	}

} // end of DAORegistroHistorico
?>
