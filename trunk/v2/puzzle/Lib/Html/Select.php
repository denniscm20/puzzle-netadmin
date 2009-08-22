<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



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

?>
