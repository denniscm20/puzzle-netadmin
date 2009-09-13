<?php

/*
 * Lib/Html/Input.php - Copyright 2009 Dennis Cohn Muroy
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
 * @class Input
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class Lib_Html_Input extends Lib_Html_Html {

    private $type = "";
    private $maxlength = 0;
    private $checked = false;

    public function __construct($id, $value, $label, $tabindex = 0, $accessKey = '')
    {
        parent::__construct($id, $value, $label, $tabindex, $accessKey);
        $this->type = "";
    }
    
    protected function show()
    {
        $basic = parent::show();
        $extra = $this->showExtra();
        $events = $this->showEvents();
        $label = "<span class=\"label\">".$this->showLabel()."</span>";
        $own = "type=\"{$this->type}\" value = \"{$this->value}\" ";
        $own .= $this->maxlength != 0?"maxlength=\"{$this->maxlength}\" ":"";
        $own .= $this->checked != false?"checked=\"checked\" ":"";
        $input = sprintf($basic, $own, $extra, $events);
        $input = "<span class=\"field\"><input ".$input." /></span>";
        return $label.$input;
    }
    
    public function showHidden()
    {
        $this->type = "hidden";
        $element = $this->show();
    }
    
    public function showTextBox($maxlength, $tooltip= "", $class = "", $style = "")
    {
        $this->type = "text";
        $this->maxlength = $maxlength;
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        return $element;
    }

    public function showPassword($maxlength, $tooltip= "", $class = "", $style = "")
    {
        $this->type = "password";
        $this->maxlength = $maxlength;
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        return $element;
    }

    public function showCheckBox($groupName, $checked, $tooltip= "", $class = "", $style = "") {
        $this->type = "checkbox";
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $this->checked = $checked;
        $this->name = $groupName."[]";
        $element = $this->show();
        return $element;
    }

    public function showRadioButton($groupName, $checked, $tooltip= "", $class = "", $style = "") {
        $this->type = "radio";
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $this->checked = $checked;
        $this->name = $groupName."[]";
        $element = $this->show();
        return $element;
    }

}

?>
