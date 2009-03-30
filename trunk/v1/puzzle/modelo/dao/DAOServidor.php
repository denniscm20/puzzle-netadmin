<?php
/**
 * @package /modelo/dao/
 * @class DAOServidor.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once 'modelo/clases/Servidor.php';
require_once DAO.'DAOIPv4Valida.php';
require_once DAO.'DAOInterfaz.php';
require_once BASE.'DAO.php';


/**
 * @class DAOServidor
 * Maneja la persistencia de los objetos Servidor con la base de datos.
 */
class DAOServidor extends DAO {

	/**
	 * Constructor del objeto DAOServidor
	 *
	 * @param modelo::clases::Servidor pServidor 
	 * @return 
	 * @access public
	 */
	public function __construct( $pServidor = null ) {
		parent::__construct($pServidor);
	} // end of member function __construct
	
	public function __destruct() {
		parent::__destruct();
	}

	/**
	 * Registra un nuevo servidor en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function agregar( ) {
		try {
			$this->aQuery = "INSERT INTO Servidor (DNS1,DNS2,Gateway,Reenvio,Hostname) VALUES (?,?,?,?,?)";
			$this->aParameters = array($this->aObjeto->DNS1, $this->aObjeto->DNS2, $this->aObjeto->Gateway, $this->aObjeto->Reenvio, $this->aObjeto->Hostname);
			return $this->insert();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function agregar

	/**
	 * Modifica los datos de un servidor existende en la base de datos.
	 *
	 * @return bool
	 * @access public
	 */
	public function modificar( ) {
		try {
			$this->aQuery = "UPDATE Servidor SET DNS1 = ?,DNS2 = ?,Gateway = ?,Reenvio = ?,Hostname = ? WHERE ID = ?";
			$this->aParameters = array($this->aObjeto->DNS1, $this->aObjeto->DNS2, $this->aObjeto->Gateway, $this->aObjeto->Reenvio, $this->aObjeto->Hostname, $this->aObjeto->ID);
			return $this->update();
		} catch (Exception $e) {
			throw $e;
		}
	} // end of member function modificar
		
	/**
	 * Permite buscar un objeto servidor por su ID.
	 *
	 * @return modelo::clases::Servidor
	 * @access public
	 */
	public function buscarID( ) {
		$this->aQuery = "SELECT * FROM Servidor WHERE ID = ?";
		$this->aParameters = array($this->aObjeto->ID);
		$lResultado = $this->select();

		$lServidor = new Servidor();
		if ($lResultado) {
			$lServidor = $this->cargarObjeto($lResultado[0]);
		}
		
		return $lServidor;
	} // end of member function buscarID

	protected function cargarObjeto($pResultado) {
		$lServidor = new Servidor();
		$lServidor->ID =$pResultado['ID'];
		$lServidor->DNS1 = $pResultado['DNS1'];
		$lServidor->DNS2 = $pResultado['DNS2'];
		$lServidor->Gateway = $pResultado['Gateway'];
		$lServidor->Reenvio = $pResultado['Reenvio'];
		$lServidor->Hostname = $pResultado['Hostname'];
		
		$lDAOInterfaz = new DAOInterfaz();
		$lServidor->Interfaces = $lDAOInterfaz->listarPorServidor($lServidor->ID);
		
		$lDAOIPv4Valida = new DAOIPv4Valida();
		$lServidor->IpHabiles = $lDAOIPv4Valida->listarPorServidor($lServidor->ID);
		return $lServidor;
	}

} // end of DAOServidor
?>
