<?php

/*
 * Lib/Html/Input.php - Copyright 2009 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * tiny-weblog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * tiny-weblog is distributed in the hope that it will be useful,
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
 * @class Input
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class Lib_Html_Input extends Lib_Html_Html {

    const LABEL_LEFT = "left";
    const LABEL_RIGHT = "right";
    
    private $orientation = "";
    private $label = "";
    private $type = "";
    private $size = "";
    private $value = "";

    public function __construct($id, $value, $label, $tabindex = 0, $class = "", $style = "") 
    {
        parent::construct($id, $tabindex, $class, $style);
        $this->orientation = Lib_Html_Input::LABEL_LEFT;
        $this->label = $label;
        $this->value = $value;
        $this->type = "";
    }
    
    protected function show()
    {
        $element = "<input type=\"{$this->type}\"";
        $element .= " id = \"{$this->id}\"";
        $element .= " name = \"{$this->name}\"";
        $element .= " value = \"{$this->value}\"";
        $element .= "%s />";
        return $element;
    }
    
    public function showHidden() {
        $this->type = "hidden";
        $element = $this->show();
        return sprintf($element, "");
    }
    
    public function showTextBox() {
        $this->type = "text";
        $element = $this->show();

        if (isset($pSize)) {
            $lTextBox .= " size = \"".$pSize."\"";
        }
        if (isset($pMaxLength)) {
            $lTextBox .= " maxlength = \"".$pMaxLength."\"";
        }
        $lTextBox .= " tabindex = \"".$pTabIndex."\"";
        $lTextBox .= " class = \"".$pStyle."\"";
        $lTextBox .= " onclick = \"".$pOnClick."\"";
        $lTextBox .= " />";

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
        $lPassword = "<input type=\"password\"";
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
        $lPassword .= " />";

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
        $lCheckBox = "<input type=\"checkbox\"";
        $lCheckBox .= " name = \"".$pName."\"";
        $lCheckBox .= " value = \"".$pValue."\"";
        if ($pChecked) {
            $lCheckBox .= " checked = \"checked\"";
        }
        $lCheckBox .= " tabindex = \"".$pTabIndex."\"";
        $lCheckBox .= " class = \"".$pStyle."\"";
        $lCheckBox .= " />";

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
        $lRadioButton = "<input type=\"radio\"";
        $lRadioButton .= " name = \"".$pName."\"";
        $lRadioButton .= " value = \"".$pValue."\"";
        if ($pChecked) {
            $lRadioButton .= " checked = \"checked\"";
        }
        $lRadioButton .= " tabindex = \"".$pTabIndex."\"";
        $lRadioButton .= " class = \"".$pStyle."\"";
        $lRadioButton .= " />";

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
        $lHidden = "<input type=\"hidden\"";
        $lHidden .= " name = \"".$pName."\"";
        $lHidden .= " value = \"".$pValue."\"";
        $lHidden .= " />";

        return $lHidden;
    }

}

?>
