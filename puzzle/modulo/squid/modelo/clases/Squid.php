<?php
/**
 * @package /modulo/Squid/modelo/clases/
 * @class Valor.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Clase.php';
require_once BASE.'IModulo.php';
require_once CLASES.'Interfaz.php';
require_once CLASES_SQUID.'PuertoSquid.php';
require_once CLASES_SQUID.'ReglaSquid.php';
require_once CLASES_SQUID.'ReglaPredefinida.php';


/**
 * class Squid
 * Esta clase representa las configuraciones básicas de la herramienta Squid.
 */
class Squid extends Clase implements IModulo {

	/*** Attributes: ***/

	/**
	 * @access private
	 */
	private $aIcpPort;

	/**
	 * @access private
	 */
	private $aVisibleHostname = "";

	/**
	 * @access private
	 */
	private $aCacheDir = "";

	/**
	 * @access private
	 */
	private $aCacheMaxSize;

	/**
	 * @access private
	 */
	private $aDirNumber1;

	/**
	 * @access private
	 */
	private $aDirNumber2;

	/**
	 * @access private
	 */
	private $aCacheLog = "";

	/**
	 * @access private
	 */
	private $aStoreLog = "";

	/**
	 * @access private
	 */
	private $aAccessLog = "";

	/**
	 * @access private
	 */
	private $aLogFqdn;

	/**
	 * @access private
	 */
	private $aDnsNameservers = "";

	/**
	 * @access private
	 */
	private $aTransparent;
	
	/**
	* @access private
	*/
	private $aActivo = false;
	
	private $aHttpPort = array();
	private $aReglasSquid = array();
	private $aReglasPredefinidas = array();

	public function __construct() {
		$this->aIcpPort = 0;
		$this->aVisibleHostname = gethostbyaddr("127.0.0.1");
		$this->aCacheDir = "/var/spool/squid/";
		$this->aCacheMaxSize = 100;
		$this->aDirNumber1 = 16;
		$this->aDirNumber2 = 256;
		$this->aCacheLog = "/var/log/squid/cache.log";
		$this->aStoreLog = "/var/log/squid/store.log";
		$this->aAccessLog = "/var/log/squid/access.log";
		$this->aLogFqdn = false;
		$this->aDnsNameservers = "";
		$this->aTransparent = true;
		$this->aActivo = false;
		$this->aHttpPort = array();
		$this->aReglasSquid = array();
		$this->aReglasPredefinidas = array();
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

	/**
	 *
	 * @return 
	 * @access public
	 */
	public function generarXML() {
		$lConfiguracion = array();
		array_push($lConfiguracion, "<?xml version='1.0' standalone='yes'?>");
		array_push($lConfiguracion, "<Modulo>");
		array_push($lConfiguracion, "<Squid>");
		array_push($lConfiguracion, "<IcpPort>".$this->aIcpPort."</IcpPort>");
		array_push($lConfiguracion, "<VisibleHostname>".$this->aVisibleHostname."</VisibleHostname>");
		array_push($lConfiguracion, "<CacheDir>".$this->aCacheDir."</CacheDir>");
		array_push($lConfiguracion, "<CacheMaxSize>".$this->aCacheMaxSize."</CacheMaxSize>");
		array_push($lConfiguracion, "<DirNumber1>".$this->aDirNumber1."</DirNumber1>");
		array_push($lConfiguracion, "<DirNumber2>".$this->aDirNumber2."</DirNumber2>");
		array_push($lConfiguracion, "<CacheLog>".$this->aCacheLog."</CacheLog>");
		array_push($lConfiguracion, "<StoreLog>".$this->aStoreLog."</StoreLog>");
		array_push($lConfiguracion, "<AccessLog>".$this->aAccessLog."</AccessLog>");
		array_push($lConfiguracion, "<LogFqdn>".$this->aLogFqdn."</LogFqdn>");
		array_push($lConfiguracion, "<DnsNameservers>".$this->aDnsNameservers."</DnsNameservers>");
		array_push($lConfiguracion, "<Transparent>".$this->aTransparent."</Transparent>");
		array_push($lConfiguracion, "<HttpPorts>");
		foreach ($this->aHttpPort as $lHttpPort)
			$lConfiguracion = array_merge($lConfiguracion, $lHttpPort->generarXML());
		array_push($lConfiguracion, "</HttpPorts>");
		array_push($lConfiguracion, "<ReglasSquid>");
		foreach ($this->aReglasSquid as $lReglaSquid)
			$lConfiguracion = array_merge($lConfiguracion, $lReglaSquid->generarXML());
		array_push($lConfiguracion, "</ReglasSquid>");
		array_push($lConfiguracion, "<ReglasPredefinidas>");
		foreach ($this->aReglasPredefinidas as $lReglaPredefinida)
			$lConfiguracion = array_merge($lConfiguracion, $lReglaPredefinida->generarXML());
		array_push($lConfiguracion, "</ReglasPredefinidas>");
		array_push($lConfiguracion, "</Squid>");
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
		
		$lTransparente =  $this->aTransparent?" transparent":"";
		
		if (count($this->aHttpPort) > 0) {
			foreach ($this->aHttpPort as $lPuertoSquid) {
				$lDescripcion = "# ".$lPuertoSquid->Descripcion;
				$lPuerto = "http_port ".($lPuertoSquid->Interfaz->ID > 0?$lPuertoSquid->Interfaz->IP.":":"").$lPuertoSquid->Puerto;
				array_push($lConfiguracion, $lDescripcion, $lPuerto.$lTransparente);
			}
		} else {
			array_push($lConfiguracion, "http_port 3128".$lTransparente);
		}
		array_push($lConfiguracion, "icp_port ".$this->aIcpPort);
				
		array_push($lConfiguracion, "cache_dir ufs ".$this->aCacheDir." ".$this->aCacheMaxSize." ".$this->aDirNumber1." ".$this->aDirNumber2);
		array_push($lConfiguracion, "cache_log  ".$this->aCacheLog);
		array_push($lConfiguracion, "cache_store_log ".$this->aStoreLog);
		array_push($lConfiguracion, "access_log ".$this->aAccessLog." squid");
		array_push($lConfiguracion, "log_fqdn ".($this->aLogFqdn?"on":"off"));
		
		if (trim($this->aDnsNameservers) != "") {
			array_push($lConfiguracion, "dns_nameservers ".$this->aDnsNameservers);
		}
		
		array_push($lConfiguracion, "acl all src 0.0.0.0/0.0.0.0");
		array_push($lConfiguracion, "acl manager proto cache_object");
		array_push($lConfiguracion, "acl localhost src 127.0.0.1/255.255.255.255");
		array_push($lConfiguracion, "acl to_localhost dst 127.0.0.0/8");
		array_push($lConfiguracion, "acl SSL_ports port 443 563");
		array_push($lConfiguracion, "acl Safe_ports port 80");
		array_push($lConfiguracion, "acl Safe_ports port 21");
		array_push($lConfiguracion, "acl Safe_ports port 443 563");
		array_push($lConfiguracion, "acl Safe_ports port 70");
		array_push($lConfiguracion, "acl Safe_ports port 210");
		array_push($lConfiguracion, "acl Safe_ports port 1025-65535");
		array_push($lConfiguracion, "acl Safe_ports port 280");
		array_push($lConfiguracion, "acl Safe_ports port 488");
		array_push($lConfiguracion, "acl Safe_ports port 591");
		array_push($lConfiguracion, "acl Safe_ports port 777");
		
		foreach ($this->aReglasPredefinidas as $lReglaPredefinida) {
			array_push($lConfiguracion, $lReglaPredefinida->Regla);
		}
		if (count ($this->aReglasPredefinidas) > 0) {
			array_push($lConfiguracion, "http_access deny ReglaPredefinida");
		}
		
		foreach ($this->aReglasSquid as $lRegla) {
			if ($lRegla->Accion->ID) {
				$lACL = $lRegla->ListaControlAcceso;
				$lValores = "";
				foreach ($lACL->Valores as $lValor) {
					$lValores .= $lValor->Nombre." ";
				}
				array_push($lConfiguracion, "acl ".$lACL->Nombre." ".$lACL->TipoACL->Nombre." ".$lValores);
			}
		}
		foreach ($this->aReglasSquid as $lRegla) {
			array_push($lConfiguracion, $lRegla->TipoAcceso->Nombre." ".$lRegla->Accion->Nombre." ".$lRegla->ListaControlAcceso->Nombre);
		}
		
		array_push($lConfiguracion, "http_access allow manager localhost");
		array_push($lConfiguracion, "http_access deny manager");
		array_push($lConfiguracion, "http_access deny !Safe_ports");
		array_push($lConfiguracion, "http_access deny !SSL_ports");
		array_push($lConfiguracion, "http_access allow localhost");
		
		array_push($lConfiguracion, "icp_access allow all");
		array_push($lConfiguracion, "visible_hostname ".$this->aVisibleHostname);
		array_push($lConfiguracion, "coredump_dir ".$this->aCacheDir);
		
		array_push($lConfiguracion, "always_direct allow all");
		
		return $lConfiguracion;
	} // end of member function generarConfiguracion

} // end of Squid
?>
