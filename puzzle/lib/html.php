<?php

/**
 * @package /lib/
 * @class HTML
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class HTML {
	
	const WRAP_OFF = "off";
	const WRAP_VIRTUAL = "virtual";
	const WRAP_PHYSICAL = "physical";

	const CHECK_ON = "ON";
	const CHECK_OFF = "OFF";
	
	/**
	 * Retorna un componente html del tipo textarea.
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param integer $pRows Numero de filas.
	 * @param integer $pCols Numero de columnas.
	 * @param string $pWrap Indica si el componente manejara un ajuste de linea.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el textarea.
	 */
	public static function TextArea($pName, $pValue, $pRows = 5, $pCols = 100, $pWrap = "off", $pTabIndex = 0, $pStyle = "") {
		$lTextArea = "<textarea";
		$lTextArea .= " id = \"".$pName."\""; 
		$lTextArea .= " name = \"".$pName."\""; 
		$lTextArea .= " rows = \"".$pRows."\"";
		$lTextArea .= " cols = \"".$pCols."\"";
		$lTextArea .= " wrap = \"".$pWrap."\"";
		$lTextArea .= " tabindex = \"".$pTabIndex."\"";
		$lTextArea .= " class = \"".$pStyle."\"";
		$lTextArea .= ">".$pValue."</textarea>";

		return $lTextArea;
	}
	
	/**
	 * Retorna un componente html del tipo textbox.
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param integer $pSize Caracteres mostrados.
	 * @param integer $pMaxLength Maximo numero de caracteres permitidos.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el textbox.
	 */
	public static function TextBox($pName, $pValue, $pSize, $pMaxLength, $pTabIndex = 0, $pStyle = "") {
		$lTextBox = "<INPUT type=\"text\"";
		$lTextBox .= " id = \"".$pName."\"";
		$lTextBox .= " name = \"".$pName."\"";
		$lTextBox .= " value = \"".$pValue."\"";
		if (isset($pSize)) {
			$lTextBox .= " size = \"".$pSize."\"";
		}
		if (isset($pMaxLength)) {
			$lTextBox .= " maxlength = \"".$pMaxLength."\"";
		}
		$lTextBox .= " tabindex = \"".$pTabIndex."\"";
		$lTextBox .= " class = \"".$pStyle."\"";
		$lTextBox .= " >";

		return $lTextBox;
	}

	/**
	 * Retorna un componente html del tipo password
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param integer $pSize Caracteres mostrados.
	 * @param integer $pMaxLength Maximo numero de caracteres permitidos.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el password.
	 */
	public static function Password($pName, $pValue, $pSize, $pMaxLength, $pTabIndex = 0, $pStyle = "") {
		$lPassword = "<INPUT type=\"password\"";
		$lPassword .= " id = \"".$pName."\"";
		$lPassword .= " name = \"".$pName."\"";
		$lPassword .= " value = \"".$pValue."\"";
		if (isset($pSize)) {
			$lPassword .= " size = \"".$pSize."\"";
	        }
		if (isset($pMaxLength)) {
			$lPassword .= " maxlength = \"".$pMaxLength."\"";
		}
		$lPassword .= " tabindex = \"".$pTabIndex."\"";
		$lPassword .= " class = \"".$pStyle."\"";
		$lPassword .= " >";

		return $lPassword;
	}

	/**
	 * Retorna un componente html del tipo checkbox
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param boolean $pChecked Indica si el checkbox estara seleccionado.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el checkbox.
	 */
	public static function CheckBox($pName, $pValue, $pChecked = false, $pTabIndex = 0, $pStyle = "") {
		$lCheckBox = "<INPUT type=\"checkbox\"";
		$lCheckBox .= " name = \"".$pName."\"";
		$lCheckBox .= " value = \"".$pValue."\"";
		if ($pChecked) {
			$lCheckBox .= " checked";
		}
		$lCheckBox .= " tabindex = \"".$pTabIndex."\"";
		$lCheckBox .= " class = \"".$pStyle."\"";
		$lCheckBox .= " >";

		return $lCheckBox;
	}

	/**
	 * Retorna un componente html del tipo radio button
	 *
	 * @param string $pName Nombre y grupo del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param boolean $pChecked Indica si el radio button estara seleccionado.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el radio button.
	 */
	public static function RadioButton($pName, $pValue, $pChecked = false, $pTabIndex = 0, $pStyle = "") {
		$lRadioButton = "<INPUT type=\"radio\"";
		$lRadioButton .= " name = \"".$pName."\"";
		$lRadioButton .= " value = \"".$pValue."\"";
		if ($pChecked) {
			$lRadioButton .= " checked";
		}
		$lRadioButton .= " tabindex = \"".$pTabIndex."\"";
		$lRadioButton .= " class = \"".$pStyle."\"";
		$lRadioButton .= " >";

		return $lRadioButton;
	}

	/**
	 * Retorna un componente html del tipo hidden
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @return string cadena html para formar el hidden.
	 */
	public static function Hidden($pName, $pValue) {
		$lHidden = "<INPUT type=\"hidden\"";
		$lHidden .= " name = \"".$pName."\"";
		$lHidden .= " value = \"".$pValue."\"";
		$lHidden .= " >";

		return $lHidden;
	}

	/**
	 * Retorna un componente html del tipo combobox
	 *
	 * @param string $pName Nombre del componente.
	 * @param array $pValue Valores que almacenara el componente.
	 * @param mixed $pValueName Nombre del campo o indice que contiene el value
	 * @param string $pText Nombre del campo o indice a mostrar
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @param string $pEvent Evento a ejecutar al seleccionar una opcion del combo box
	 * @return string cadena html para formar el combobox.
	 */
	public static function ComboBox($pName, $pValue, $pValueName = "0", $pText = "", $pTabIndex = 0, $pSelectedID = "0", $pStyle = "", $pEvent = "") {
		$lComboBox = "<select";
		$lComboBox .= " name = \"".$pName."\"";
		$lComboBox .= " tabindex = \"".$pTabIndex."\"";
		$lComboBox .= " class = \"".$pStyle."\"";
		$lComboBox .= " onchange = \"".$pEvent."\"";
		$lComboBox .= ">\n";
		$lComboBox .= "<option value=\"0\">Seleccione</option>\n";
		if (is_array($pValue)) {
			for ($i = 0; $i < count($pValue); $i++) {
				$objeto = $pValue[$i];
				$lComboBox .= "<option value=\"".$objeto->$pValueName."\" ".($objeto->$pValueName == $pSelectedID?"selected":"").">".$objeto->$pText."</option>\n";
			}
		}
		$lComboBox .= "</select>";

		return $lComboBox;
	}

	/**
	 * Retorna un componente html del tipo lista
	 *
	 * @param string $pName Nombre del componente.
	 * @param array $pValue Valores que almacenara el componente.
	 * @param integer $pSize Items visibles en la lista.
	 * @param mixed $pValueName Nombre del campo o indice que contiene el value
	 * @param string $pText Nombre del campo o indice a mostrar
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar la lista.
	 */
	public static function ListItems($pName, $pValue, $pSize, $pValueName, $pText, $pTabIndex = 0, $pStyle = "") {
		$lList = "<select";
		$lList .= " name = \"".$pName."\" multiple=\"yes\"";
		$lList .= " tabindex = \"".$pTabIndex."\"";
		$lList .= " class = \"".$pStyle."\"";
		if (isset($pSize)) {
			$lList .= " size = \"".$pSize."\"";
		}
		$lList .= ">";
		if (is_array($pValue)) {
			for ($i = 0; $i < count($pValue); $i++) {
				$objeto = $pValue[$i];
				$lList .= "<option value=\"".$objeto->$pValueName."\">".$objeto->$pText."</option>\n";
			}
		}
		$lList .= "</select>";

		return $lList;
	}

	/**
	 * Retorna un componente html del tipo submit button
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el submit button.
	 */
	public static function SubmitButton($pName, $pValue, $pTabIndex = 0, $pStyle = "") {
		$lButton = "<INPUT type=\"submit\"";
		$lButton .= " name = \"".$pName."\"";
		$lButton .= " value = \"".$pValue."\"";
		$lButton .= " tabindex = \"".$pTabIndex."\"";
		$lButton .= " class = \"".$pStyle."\"";
		$lButton .= " >";

		return $lButton;
	}

	/**
	 * Retorna un componente html del tipo reset button
	 *
	 * @param string $pName Nombre del componente.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @return string cadena html para formar el reset button.
	 */
	public static function ResetButton($pName, $pValue, $pTabIndex = 0, $pStyle = "") {
		$lButton = "<INPUT type=\"reset\"";
		$lButton .= " name = \"".$pName."\"";
		$lButton .= " value = \"".$pValue."\"";
		$lButton .= " tabindex = \"".$pTabIndex."\"";
		$lButton .= " class = \"".$pStyle."\"";
		$lButton .= " >";

		return $lButton;
	}

	/**
	 * Retorna un componente html del tipo image button
	 *
	 * @param string $pName Nombre del componente.
	 * @param string $pSrc Ruta de la imagen.
	 * @param mixed $pValue Valor que almacenara el componente.
	 * @param integer $pTabIndex Indica el indice de tab asignado al componente.
	 * @param string $pStyle Estilo css que utilizará el componente.
	 * @param string $pEvent Evento a ejecutarse al presionar el componente
	 * @return string cadena html para formar el image button.
	 */
	public static function ImageButton($pName, $pSrc = "", $pValue, $pTabIndex = 0, $pStyle = "", $pEvent = "") {
		$lButton = "<INPUT type=\"image\"";
		$lButton .= " name = \"".$pName."\"";
		$lButton .= " src = \"".$pSrc."\"";
		$lButton .= " value = \"".$pValue."\"";
		$lButton .= " title = \"".$pValue."\"";
		$lButton .= " tabindex = \"".$pTabIndex."\"";
		$lButton .= " class = \"".$pStyle."\"";
		$lButton .= " onclick = \"".$pEvent."\"";
		$lButton .= " >";

		return $lButton;
	}
	
	/**
	* Retorna un componente html del tipo button
	*
	* @param string $pName Nombre del componente.
	* @param mixed $pValue Valor que almacenara el componente.
	* @param integer $pTabIndex Indica el indice de tab asignado al componente.
	* @param string $pStyle Estilo css que utilizará el componente.
	* @param string $pEvent Evento a ejecutarse al presionar el botón
	* @return string cadena html para formar el button.
	*/
	public static function Button($pName, $pValue, $pTabIndex = 0, $pStyle = "", $pEvent="") {
		$lButton = "<INPUT type=\"button\"";
		$lButton .= " name = \"".$pName."\"";
		$lButton .= " value = \"".$pValue."\"";
		$lButton .= " tabindex = \"".$pTabIndex."\"";
		$lButton .= " class = \"".$pStyle."\"";
		$lButton .= " onclick = \"".$pEvent."\"";
		$lButton .= " >";

		return $lButton;
	}

}

?>
