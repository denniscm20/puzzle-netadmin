<?php

/**
 * @package /lib/
 * @class Validator
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class Validator {
	
	/**
	 * Valida que el parametro sea un texto valido.
	 *
	 * @param string $pText Cadena a validar.
	 * @param int $pLongitud Longitud máxima que debe de tener la cadena
	 * @return boolean valor de verdad.
	 */
	public static function validarTexto($pText, $pLongitud = 10) {
	}
	
	/**
	* Valida que el parametro sea una dirección IP válida
	*
	* @param string $pIP Dirección IP.
	* @return boolean valor de verdad.
	*/
	public static function validarIp4($pIP) {
		$ipPattern = '/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.' .
				'(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.' .
				'(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.' .
				'(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/';

		return preg_match($ipPattern, $pIP);
	}
	
	/**
	* Valida que la máscara corta pertenezca a la máscara.  Esta función no verifica que el formato de máscara sea correcto
	*
	* @param string $pMascara Máscara en formato largo.
	* @param string $pMascaraCorta Máscara en formato corto.
	* @return boolean valor de verdad.
	*/
	public static function validarMascara_MascaraCorta($pMascara, $pMascaraCorta) {
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
		
		if ($lMaskNumber == $pMascaraCorta) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	* Valida que la máscara corta pertenezca a la máscara.  Esta función no verifica que el formato de máscara sea correcto
	*
	* @param string $pIP Dirección IP del nodo.
	* @param string $pMascara Máscara del nodo.
	* @param string $pSubredIP Dirección IP de la subred.
	* @return boolean valor de verdad.
	*/
	public static function validarIP_Subred($pIP, $pMascara, $pSubredIP) {
		$lIP = explode(".",$pIP);
		$lMascara = explode(".",$pMascara);
		$lSubredIP = explode(".",$pSubredIP);
		
		if (count($lIP) == count($lMascara) and count($lSubredIP) == count($lIP) and count($lIP) == 4) {
			for ($i = 0; $i < 4; $i ++ ) {
				$lM = 0 + $lMascara[$i];
				if (($lIP[$i] & $lM) != ($lSubredIP[$i] & $lM)) {
					return false;
				}
			}
		} else {
			return false;
		}
		return true;
	}
	
	/**
	* Valida que la máscara presente un formato IPv4
	*
	* @param string $pMascara Máscara a validar.
	* @return boolean valor de verdad.
	*/
	public static function validarMascaraIp4($pMascara) {
		$lValues = explode(".",$pMascara);
		$lCount = count($lValues);
		
		if ($lCount != 4) {
			return false;
		}
		
		for ($i = 0; $i < $lCount; $i++) {
			$lValue = $lValues[$i];
			if (is_numeric($lValues[$i])) {
				if ($lValue > 255 or $lValue < 0) {
					return false;
				}
			} else {
				return false;
			}
		}
		
		$lZero_flag = false;
		for ($i = 0; $i < $lCount; $i++) {
			$lValue = $lValues[$i];
			$lMask = 0x1;
			for ($j = 0; $j < 8; $j++) {
				$lBit = ($lValue >> (7 - $j)) & $lMask;
				if ($lBit and $lZero_flag) {
					$lZero_flag = false;
				}
				if ($lBit == 0) {
					$lZero_flag = true;
				}
			}
		}
		
		return true;
	}
	
	/**
	* Valida que el parametro sea una máscara corta válida
	*
	* @param string $pMascaraCorta Máscara corta a validar.
	* @return boolean valor de verdad.
	*/
	public static function validarMascaraCorta ($pMascaraCorta) {
		if (is_numeric($pMascaraCorta)) {
			if ($pMascaraCorta < 0 or $pMascaraCorta > 32) {
				return false;
			}
			return true;
		}
		return false;
	}
	
	/**
	* Valida que el parametro sea un número real válido.
	*
	* @param string $pText Número real a validar.
	* @param int $pDecimal Número de decimales máximos permitidos.
	* @return boolean valor de verdad.
	*/
	public static function validarReal ($pNumero, $pDecimales) {
	}
}