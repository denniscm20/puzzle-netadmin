<?php

/**
 * @class File Esta clase brinda las funciones de creación, escritura y lectura de archivos de texto plano;
 */

class File {
	
	private $aRuta = "";
	private $aNombre;
	private $aTemporal = false;
	private $aModo;
	
	private $aHandler = false;
	
	/**
	 * Esta función permite crear una nueva instacia de la clase File.
	 * @param string pNombre Nombre del archivo.
	 * @param char pModo Modo en el que se abre el archivo.
	 * @param string pRuta Ruta donde se localizará el archivo. En caso no se proporcione este parámetro se asumirá que la ruta es parte del parámetro pNombre.
	 * @param bool pTemporal Indica si el archivo creado es un archivo temporal.  Su valor predeterminado es false
	 */
	public function __construct($pNombre, $pModo, $pRuta = "", $pTemporal = false) {
		$this->aNombre = $pNombre;
		$this->aRuta = $pRuta;
		$this->aModo = $pModo;
		$this->aTemporal = $pTemporal;
		
		$this->aHandler = false;
	}
	
	public function __destruct() {
	}
	
	/**
	 * Esta función permite conocer si el archivo físico existe.
	 */
	public function existe() {
		return file_exists($this->aRuta.$this->aNombre);
	}
	
	/**
	* Esta función permite escribir varias líneas en un archivo.
	* @param array pLineas Conjunto de líneas a escribir.
	*/
	public function escribirLineas($pLineas) {
		try {
			$this->abrirArchivo();
			foreach ($pLineas as $lLinea) {
				$this->escribirLinea($lLinea);
			}
			$this->cerrarArchivo();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	* Esta función permite escribir una línea en un archivo.
	* @param array pLineas Línea a escribir.
	*/
	public function escribirLinea($pLinea) {
		try {
			$lNombre = $this->aRuta.$this->aNombre;
			if (is_writable($lNombre)) {
				if (!strpos($pLinea,"\n")) {
					$pLinea .= "\n";
				}
				fwrite($this->aHandler,$pLinea);
			} else {
				throw new Exception("Input Error");
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	* Esta función permite leer las líneas de un archivo de texto.
	* @return Arreglo de líneas leidas.
	*/
	public function leerLineas() {
		try {
			$lLineas = array();
			$this->abrirArchivo();
			while (!feof($this->aHandler)) {
				$lLineas[] = $this->leerLinea();
			}
			$this->cerrarArchivo();
			return $lLineas;
		} catch (exception $e) {
			throw $e;
		}
	}
	
	/**
	* Esta función permite leer una línea de un archivo de texto.
	* @return Línea leida.
	*/
	public function leerLinea() {
		try {
			$lNombre = $this->aRuta.$this->aNombre;
			if (is_readable($lNombre) ) {
				$lLinea = fgets($this->aHandler);
				return $lLinea;
			} else {
				throw new Exception("Output Error");
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function carmbiarModo($pModo) {
		try {
			fclose($this->aHandler);
			$this->aModo = $pModo;
			$this->abrirArchivo();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function abrirArchivo() {
		try {
			$this->aHandler = fopen($this->aRuta.$this->aNombre,$this->aModo);
			if (!$this->aHandler) {
				throw new Exception ("I/O Error");
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function cerrarArchivo() {
		fclose($this->aHandler);
		if ($this->aTemporal) {
			delete($this->aRuta.$this->aNombre);
		}
	}
	
}

?>