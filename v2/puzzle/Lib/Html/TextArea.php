<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



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

?>
