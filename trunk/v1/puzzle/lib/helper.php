<?php

/**
 * @package /lib/
 * @class Helper
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
 
class Helper {
	
	public static function cargarModulos () {
		$lModulos = scandir(MODULO);
		$lContador = count($lModulos);
		for ($i = 0; $i < $lContador; $i ++ ) {
			$lFileName = MODULO.$lModulos[$i]."/config.php";
			if (file_exists($lFileName)) {
				require_once ($lFileName);
			}
		}
	}
	
	public static function validarModulo ($pModulo) {
		$lFileName = MODULO.$pModulo."/config.php";
		if (file_exists($lFileName)) {
			return MODULO.$pModulo;
		}
		return false;
	}
	
	public static function validarPagina ($pPagina, $pModulo) {
		$lPagina = PAGINA_PREDEFINIDA;
		
		if ($pModulo == "") {
			$lPagina = (file_exists(VISTA."Vista".$pPagina.".php"))?$pPagina:PAGINA_PREDEFINIDA;
		} else {
			$lPagina = (file_exists(MODULO.$pModulo."/vista/Vista".$pPagina.".php"))?$pPagina:PAGINA_PREDEFINIDA;
		}
		
		return $lPagina;
	}
	
	public static function obtenerNombrePorIP ($pIP) {
		return gethostbyaddr($pIP);
	}
	
	public static function maskToShortMask ($pMascara) {
		$lValues = explode(".",$pMascara);
		$lCount = count($lValues);

		if ($lCount != 4) {
			return false;
		}
		
		$lMaskNumber = 0;
		$lZeroValue = false;
		
		for ($i = 0; $i < $lCount; $i++) {
			$lValue = $lValues[$i];
			$lMask = 0x1;
			for ($j = 0; $j < 8; $j++) {
				$lBit = ($lValue >> (7 - $j)) & $lMask;
				if ($lBit) {
					$lMaskNumber++;
				} else {
					$lZeroValue = true;
					break;
				}
			}
			if ($lZeroValue) {
				break;
			}
		}
		return $lMaskNumber;
	}
	
	public static function cambiarFormatoFecha($pFecha, $pFormatoFinal) {
		return date($pFormatoFinal,strtotime($pFecha));
	}

}

?>