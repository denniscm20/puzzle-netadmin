<?php

/*
 * Lib/Html/Button.php - Copyright 2009 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * puzzle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * puzzle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with puzzle.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once PATH_LIB.'Html/Html.php';

/**
 * @package /Lib/
 * @subpackage /Html/
 * @class Button
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class Lib_Html_Button extends Lib_Html_Html
{




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
        $lButton = "<input type=\"submit\"";
        $lButton .= " name = \"".$pName."\"";
        $lButton .= " value = \"".$pValue."\"";
        $lButton .= " tabindex = \"".$pTabIndex."\"";
        $lButton .= " class = \"".$pStyle."\"";
        $lButton .= " />";

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
        $lButton = "<input type=\"reset\"";
        $lButton .= " name = \"".$pName."\"";
        $lButton .= " value = \"".$pValue."\"";
        $lButton .= " tabindex = \"".$pTabIndex."\"";
        $lButton .= " class = \"".$pStyle."\"";
        $lButton .= " />";

        return $lButton;
    }

    /**
     * Retorna un componente html del tipo image button
     *
     * @param string $pName Nombre del componente.
     * @param mixed $pValue Valor que almacenara el componente.
     * @param string $pSrc Ruta de la imagen.
     * @param integer $pTabIndex Indica el indice de tab asignado al componente.
     * @param string $pStyle Estilo css que utilizará el componente.
     * @param string $pEvent Evento a ejecutarse al presionar el componente
     * @return string cadena html para formar el image button.
     */
    public static function ImageButton($pName, $pValue, $pSrc = "", $pTabIndex = 0, $pStyle = "", $pEvent = "") {
        $lButton = "<input type=\"image\"";
        $lButton .= " name = \"".$pName."\"";
        $lButton .= " src = \"".$pSrc."\"";
        $lButton .= " value = \"".$pValue."\"";
        $lButton .= " title = \"".$pValue."\"";
        $lButton .= " tabindex = \"".$pTabIndex."\"";
        $lButton .= " class = \"".$pStyle."\"";
        $lButton .= " onclick = \"".$pEvent."\"";
        $lButton .= " />";

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
        $lButton = "<input type=\"button\"";
        $lButton .= " name = \"".$pName."\"";
        $lButton .= " value = \"".$pValue."\"";
        $lButton .= " tabindex = \"".$pTabIndex."\"";
        $lButton .= " class = \"".$pStyle."\"";
        $lButton .= " onclick = \"".$pEvent."\"";
        $lButton .= " />";

        return $lButton;
    }

    protected function show()
    {
    }

}
?>
