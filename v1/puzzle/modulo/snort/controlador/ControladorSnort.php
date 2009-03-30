<?php
/**
 * @package /controlador/
 * @class ControladorSnort
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once BASE.'Controlador.php';
require_once CLASES_SNORT.'Snort.php';
require_once CLASES_SNORT.'HistoricoSnort.php';
require_once CLASES_SNORT.'TipoLibreria.php';
require_once CLASES_SNORT.'TipoValor.php';
require_once CLASES_SNORT.'TipoPreprocesador.php';
require_once CLASES_SNORT.'Parametro.php';
require_once DAO_SNORT.'DAOSnort.php';
require_once DAO_SNORT.'DAOHistoricoSnort.php';
require_once DAO_SNORT.'DAOTipoLibreria.php';
require_once DAO_SNORT.'DAOTipoPreprocesador.php';
require_once DAO_SNORT.'DAOTipoValor.php';
require_once DAO_SNORT.'DAOParametro.php';
require_once CLASES.'Interfaz.php';
require_once DAO.'DAOInterfaz.php';
require_once LIB.'File.php';

/**
 * @class ControladorSnort
 * Controlador de la pantalla VistaSnort
 */
class ControladorSnort extends Controlador {

	private $aSnort = null;
	private $aTipoPreprocesadores = null;
	private $aTipoLibrerias = null;
	private $aTipoValores = null;
	private $aInterfaces = null;
	private $aNodos = null;
	private $aTipoServicios = null;
	private $aParametros = null;
	private $aParametro = null;
	private $aPagina = 0;
	
	/**
	 * Obtiene una instancia del objeto ControladorServidor
	 *
	 * @return controlador::ControladorServidor
	 * @static
	 * @access public
	 */
	public static function obtenerInstancia( ) {
		if (self::$aControlador == null) {
			self::$aControlador = new ControladorSnort();
		}
		return self::$aControlador;
	} // end of member function obtenerInstancia

	public function procesar ($pEvento = "") {
		$this->cargarObjeto();
		switch ($pEvento) {
			case "guardar":
			case "cancelar":
			case "cargarParametros":
			case "agregar":
			case "remover":
			case "siguiente":
			case "anterior":
			case "importar":
				$this->{$pEvento}();
				break;
		}
		$this->cargarReferencias();
	}
	
	public function getSnort() {
		return $this->aSnort;
	}
	
	public function getTipoPreprocesadores() {
		return $this->aTipoPreprocesadores;
	}
	
	public function getInterfaces() {
		return $this->aInterfaces;
	}
	
	public function getPagina() {
		return $this->aPagina;
	}
	
	public function getTipoLibrerias() {
		return $this->aTipoLibrerias;
	}
	
	public function getTipoValores() {
		return $this->aTipoValores;
	}
	
	public function getTipoServicios() {
		return $this->aTipoServicios;
	}
	
	public function getNodos() {
		return $this->aNodos;
	}
	
	public function getParametros() {
		return $this->aParametros;
	}
	
	public function getTipoPreprocesadorSeleccionado() {
		return $this->aTipoPreprocesador;
	}
	
	protected function cargarObjeto() {
		if (isset($_SESSION["snort"])) {
			$this->aSnort = unserialize($_SESSION["snort"]);
		}
	}
	
	protected function cancelar( ) {
		if (isset($_SESSION["snort"])) {
			unset($_SESSION["snort"]);
		}
		header("Location: /index.php?Pagina=PanelControl");
	}

	/**
	 * Permite eliminar una dirección IP.
	 *
	 * @return bool
	 * @access public
	*/
	protected function guardar( ) {
		try {
			$this->aTotalPuertos = $_POST["TotalPuertos"];
			$this->actualizarSnort();
			$lDAOSnort = new DAOSnort($this->aSnort);
			$lDAOSnort->insertar();
			
			$lSnort = $lDAOSnort->buscarMaxID();
			
			// Agregar sub objetos
			foreach ($this->aSnort->Servicios as $lServicio) {
				$lDAOServicio = new DAOServicio($lServicio);
				$lDAOServicio->insertar($lSnort->ID);
			}
			
			foreach ($this->aSnort->Librerias as $lLibreria) {
				$lDAOLibreria = new DAOLibreria($lLibreria);
				$lDAOLibreria->insertar($lSnort->ID);
			}
			
			foreach ($this->aSnort->Preprocesadores as $lPreprocesador) {
				$lDAOPreprocesador = new DAOPreprocesador($lPreprocesador);
				$lDAOPreprocesador->insertar($lSnort->ID);
			}
			
			$lHistoricoSnort = new HistoricoSnort();
			$lHistoricoSnort->Snort = $lSnort;
			$lDAOHistoricoSnort = new DAOHistoricoSnort($lHistoricoSnort);
			$lDAOHistoricoSnort->agregar();
			
			if (isset($_SESSION["snort"])) {
				unset($_SESSION["snort"]);
			}
			
			header("Location: /index.php?Pagina=PanelControl");
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function eliminar	
	
	protected function siguiente() {
		try {
			$this->aPagina = $_POST["Pagina"];
			$this->actualizarSnort();
			$this->aPagina ++;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
		
	/**
	 * Permite buscar la información de un servidor de acuerdo a su ID.
	 *
	 * @return 
	 * @access public
	 */
	protected function anterior( ) {
		try {
			$this->aPagina = $_POST["Pagina"];
			$this->actualizarSnort();
			$this->aPagina --;
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	} // end of member function buscarID
	
	protected function actualizarSnort() {
		switch ($this->aPagina) {
			case 1: 
				$lDAOInterfaz = new DAOInterfaz();
				$this->aInterfaces = $lDAOInterfaz->listarPorServidor(1);
				$lInterfacesInternas = array();
				$lInterfacesExternas = array();
				foreach ($this->aInterfaces as $lInterfaz) {
					$lValor = isset($_POST["rdbInterfaz".$lInterfaz->ID])?$_POST["rdbInterfaz".$lInterfaz->ID]:"";
					if ($lValor == "in") {
						$lInterfacesInternas[] = $lInterfaz;
					} else if ($lValor == "out") {
						$lInterfacesExternas[] = $lInterfaz;
					}
				}
				$this->aSnort->InterfazInterna = $lInterfacesInternas;
				$this->aSnort->InterfazExterna = $lInterfacesExternas;
				break;
			case 5: 
				$this->aSnort->RutaReglas = trim($_POST["txtRuta"]);
				$this->aSnort->RecursosLimitados = isset($_POST["chkLimitado"]);
				break;
		}
		$_SESSION["snort"] = serialize($this->aSnort);
	}
	
	protected function agregar( ){
		$this->aPagina = $_POST["Pagina"];
		switch($this->aPagina) {
			case 2: 
				$lServicio = new Servicio();
				$lTipoServicio = new TipoServicio();
				$lTipoServicio->ID = $_POST["cmbServicio"];
				$lDAOTipoServicio = new DAOTipoServicio($lTipoServicio);
				$lServicio->TipoServicio = $lDAOTipoServicio->buscarID();
				$lNodosID = $_POST["lstNodos"];
				$lNodos = array();
				foreach ($lNodosID as $lNodoID) {
					$lNodo = new Nodo();
					$lNodo->ID = $lNodoID;
					$lDAONodo = new DAONodo($lNodo);
					$lNodos[] = $lDAONodo->buscarID();
				}
				$lServicio->Nodos = $lNodos;
				$lServicio->Puertos = $_POST["txtPuertos"];
				$this->aSnort->Servicios[] = $lServicio;
				break;
			case 3: 
				$lLibreria = new Libreria();
				$lTipoLibreria = new TipoLibreria();
				$lTipoLibreria->ID = $_POST["cmbTipoLibreria"];
				$lDAOTipoLibreria = new DAOTipoLibreria($lTipoLibreria);
				$lLibreria->TipoLibreria = $lDAOTipoLibreria->buscarID();
				
				$lTipoValor = new TipoValor();
				$lTipoValor->ID = $_POST["cmbValor"];
				$lDAOTipoValor = new DAOTipoValor($lTipoValor);
				$lLibreria->TipoValor = $lDAOTipoValor->buscarID();
				
				$lLibreria->Valor = $_POST["txtRuta"];
				$this->aSnort->Librerias[] = $lLibreria;
				break;
			case 4: 
				$lDAOParametros = new DAOParametro();
				$this->aParametros = $lDAOParametros->buscarTipoPreprocesador($_POST["cmbPreprocesador"]);
				
				$lPreprocesador = new Preprocesador();
				$lTipoPreprocesador = new TipoPreprocesador();
				$lTipoPreprocesador->ID = $_POST["cmbPreprocesador"];
				$lDAOTipoPreprocesador = new DAOTipoPreprocesador($lTipoPreprocesador);
				$lPreprocesador->TipoPreprocesador = $lDAOTipoPreprocesador->buscarID();
				
				$lCount = count ($this->aParametros);
				for ($i = 0; $i < $lCount; $i ++) {
					$lParametro = $this->aParametros[$i];
					$lParametro->Valor = trim($_POST["txt_".$i]);
					$this->aParametros[$i] = $lParametro;
				}
				var_dump($this->aParametros);
				$lPreprocesador->Parametros = $this->aParametros;
				$this->aSnort->Preprocesadores[] = $lPreprocesador;
				
				$this->aTipoPreprocesador->ID = 0;
				$this->aParametros = array();
				break;
		}
		$_SESSION["snort"] = serialize($this->aSnort);
	}
	
	protected function remover( ){
		$lId = $_POST["Elemento"];
		$this->aPagina = $_POST["Pagina"];
		switch($this->aPagina) {
			case 2: 
				$lServiciosAux = array();
				$lCountServicios = count($this->aSnort->Servicios);
				for ($i = 0; $i < $lCountServicios; $i ++) {
					if ($i != $lId) {
						$lServiciosAux[] = $this->aSnort->Servicios[$i];
					}
				}
				$this->aSnort->Servicios = $lServiciosAux;
				break;
			case 3: 
				$lLibreriasAux = array();
				$lCountLibrerias = count($this->aSnort->Librerias);
				for ($i = 0; $i < $lCountLibrerias; $i ++) {
					if ($i != $lId) {
						$lLibreriasAux[] = $this->aSnort->Librerias[$i];
					}
				}
				$this->aSnort->Librerias = $lLibreriasAux;
				break;
			case 4: 
				$lPreprocesadoresAux = array();
				$lCountPreprocesadores = count($this->aSnort->Preprocesadores);
				for ($i = 0; $i < $lCountPreprocesadores; $i ++) {
					if ($i != $lId) {
						$lPreprocesadoresAux[] = $this->aSnort->Preprocesadores[$i];
					}
				}
				$this->aSnort->Preprocesadores = $lPreprocesadoresAux;
				break;
		}
		$_SESSION["snort"] = serialize($this->aSnort);
	}
	
	protected function cargarParametros( ){
		$this->aPagina = $_POST["Pagina"];
		$lDAOParametros = new DAOParametro();
		$this->aParametros = $lDAOParametros->buscarTipoPreprocesador($_POST["cmbPreprocesador"]);
		$this->aTipoPreprocesador->ID = $_POST["cmbPreprocesador"];
	}
	
	protected function cargarReferencias( ) {
		try {
			$lDAOInterfaz = new DAOInterfaz();
			$this->aInterfaces = $lDAOInterfaz->listarPorServidor(1);
			
			$lDAOTipoLibreria = new DAOTipoLibreria();
			$this->aTipoLibrerias = $lDAOTipoLibreria->listar();
			
			$lDAOTipoValor = new DAOTipoValor();
			$this->aTipoValores = $lDAOTipoValor->listar();
			
			$lDAOTipoServicio = new DAOTipoServicio();
			$this->aTipoServicios = $lDAOTipoServicio->listar();

			$lDAONodo = new DAONodo();
			foreach ($this->aSnort->InterfazInterna as $lInterfaz) {
				$this->aNodos += $lDAONodo->buscarPorInterfaz($lInterfaz->ID);
			}
			
			$lDAOTipoPreprocesador = new DAOTipoPreprocesador();
			$this->aTipoPreprocesadores = $lDAOTipoPreprocesador->listar();
		} catch (Exception $e) {
			$_SESSION["error"] = $e->getMessage();
		}
	}
	
	protected function importar() {
		$lDirectorio = TMP;
		$lArchivo = $lDirectorio.basename($_FILES['txtFile']['name']);
		if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $lArchivo)) {
			//Establecer como temporal
			$lXML = new SimpleXMLElement($lArchivo, NULL, TRUE);
			
			$this->aSnort = new Snort();
			
			$lSnortXML = $lXML->Snort[0];
			$this->aSnort = new Snort();
			$this->aSnort->RutaReglas = $lSnortXML->RutaReglas;
			$this->aSnort->RecursosLimitados = $lSnortXML->RecursosLimitados;
			foreach($lSnortXML->InterfazInterna->Interfaz as $lInterfazID) {
				$lInterfaz = new Interfaz();
				$lInterfaz->ID = $lInterfazID;
				$this->aSnort->InterfazInterna[] = $lInterfaz;
			}
			foreach($lSnortXML->InterfazExterna->Interfaz as $lInterfazID) {
				$lInterfaz = new Interfaz();
				$lInterfaz->ID = $lInterfazID;
				$this->aSnort->InterfazExterna[] = $lInterfaz;
			}
			
			$lServicios = array();
			foreach ($lSnortXML->Servicios->Servicio as $lServicioXML) {
				$lServicio = new Servicio();
				$lServicio->Nombre = $lServicioXML->Nombre;
				$lServicio->Descripcion = $lServicioXML->Descripcion;
				$lServicio->Puertos = $lServicioXML->Puertos;
				$lServicio->TipoServicio->ID = $lServicioXML->TipoServicio;
				foreach ($lServicioXML->Nodos->Nodo as $lNodoID) {
					$lNodo = new Nodo();
					$lNodo->ID = $lNodoID;
					$lServicio->Nodos[] = $lNodo;
				}
				$lServicios[] = $lServicio;
			}
			$this->aSnort->Servicios = $lServicios;
			
			$lPreprocesadores = array();
			foreach ($lSnortXML->Preprocesadores->Preprocesador as $lPreprocesadorXML) {
				$lPreprocesador = new Preprocesador();
				$lPreprocesador->TipoPreprocesador->ID = $lPreprocesadorXML->TipoPreprocesador;
				foreach($lPreprocesadorXML->Parametros->Parametro as $lParametroXML) {
					$lParametro = new Parametro();
					$lParametro->ID = $lParametroXML->ID;
					$lParametro->Nombre = $lParametroXML->Nombre;
					$lParametro->Descripcion = $lParametroXML->Descripcion;
					$lParametro->Valor = $lParametroXML->Valor;
					$lPreprocesador->Parametros[] = $lParametro;
				}
				$lPreprocesadores[] = $lPreprocesador;
			}
			$this->aSnort->Preprocesadores = $lPreprocesadores;
			
			$lLibrerias = array();
			foreach ($lSnortXML->Librerias->Libreria as $lLibreriaXML) {
				$lLibreria = new Libreria();
				$lLibreria->Valor = $lLibreriaXML->Valor;
				$lLibreria->TipoLibreria->ID = $lLibreriaXML->TipoLibreria;
				$lLibreria->TipoValor->ID = $lLibreriaXML->TipoValor;
				$lLibrerias[] = $lLibreria;
			}
			$this->aSnort->Librerias = $lLibrerias;
			
			$lReglasPredefinidas = array();
			foreach ($lSnortXML->ReglasPredefinidas->ReglaPredefinida as $lReglaPredefinida) {
				$lRegla = new ReglaPredefinida();
				$lRegla->ID = $lReglaPredefinida;
				$lReglasPredefinidas[] = $lRegla;
			}
			$this->aSnort->ReglasPredefinida = $lReglasPredefinidas;
			
			/* Agregando a la BD */
			$lDAOSnort = new DAOSnort($this->aSnort);
			$lDAOSnort->insertar();
			
			$lSnort = $lDAOSnort->buscarMaxID();
			
			$lDAOSnort = new DAOSnort($lSnort);
			
			$lHistorico = new HistoricoSnort();
			$lHistorico->Snort = $lSnort;
			$lHistorico->FechaCreacion = date("Ymd");
			$lHistorico->HoraCreacion = date("H:i");
			$lHistorico->Descripcion = "Archivo importado el ".date("d-m-Y");
			
			$lDAOHistorico = new DAOHistoricoSnort($lHistorico);
			$lDAOHistorico->agregar();
			
			foreach ($this->aSnort->Servicios as $lServicio) {
				$lDAOServicio = new DAOServicio($lServicio);
				$lDAOServicio->insertar($lSnort->ID);
			}
			
			foreach ($this->aSnort->Librerias as $lLibreria) {
				$lDAOLibreria = new DAOLibreria($lLibreria);
				$lDAOLibreria->insertar($lSnort->ID);
			}
			
			foreach ($this->aSnort->Preprocesadores as $lPreprocesador) {
				$lDAOPreprocesador = new DAOPreprocesador($lPreprocesador);
				$lDAOPreprocesador->insertar($lSnort->ID);
			}
			
			foreach ($this->aSnort->ReglasPredefinida as $lReglaPredefinida) {
				$lDAOReglaPredefinida = new DAOReglaPredefinida($lReglaPredefinida);
				$lDAOReglaPredefinida->agregar($lSnort->ID);
			}
			
			$_SESSION['info'] = "El archivo ha sido importado exitosamente";
		} else {
			$_SESSION['error'] = "Se ha producido un error al importar el archivo";
		}
		if (isset($_SESSION["snort"])) {
			unset($_SESSION["snort"]);
		}
	}
	
	/**
	 * Contructor del objeto ControladorServidor
	 *
	 * @return 
	 * @access private
	 */
	private function __construct( ) {
		$this->aSnort = new Snort();
		$this->aInterfaces = array();
		$this->aTipoPreprocesadores = array();
		$this->aTipoLibrerias = array();
		$this->aTipoValores = array();
		$this->aTipoServicios = array();
		$this->aNodos = array();
		$this->aParametros = array();
		$this->aTipoPreprocesador = new TipoPreprocesador();
		$this->aPagina = 0;
	} // end of member function __construct

} // end of ControladorServidor
?>
