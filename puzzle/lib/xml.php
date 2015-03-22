<?php

/**
 * @package /lib/
 * @class XML
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
 
 class XML {
	
	private $xml = null;
	private $xmlName = null;
	
	public function __construct($pXmlName) {
		$this->xmlName = $pXmlName;
		$this->xml = simplexml_load_file($pXmlName);
	}
	
	public function __destruct() {
	}
	
	public function getXML() {
		return $this->xmlFile->asXML();
	}
	
	public function getArray() {
	}
 }
 
 ?>