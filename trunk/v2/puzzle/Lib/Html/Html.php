<?php

/*
 * Lib/Html/Html.php - Copyright 2009 Dennis Cohn Muroy
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

/**
 * @abstract
 * @package /Lib/
 * @subpackage /Html/
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
abstract class Lib_Html_Html {
    
    protected $id = "";
    protected $name = "";
    protected $accessKey = '';
    protected $tooltip = "";
    protected $tabindex = "";
    protected $label = "";
    protected $value = "";

    protected $class = "";
    protected $style = "";

    protected $blurFunction = "";
    protected $changeFunction = "";
    protected $clickFunction = "";
    protected $focusFunction = "";
    protected $mouseoutFunction = "";
    protected $mouseoverFunction = "";
    protected $keypressFunction = "";
    protected $selectFunction = "";

    protected function __construct($id, $value, $label = "", $tabindex = 0, $accessKey = "")
    {
        $this->id = $id;
        $this->name = $id;
        $this->value = $value;
        $this->label = $label;
        $this->tabindex = $tabindex;
        $this->accessKey = $accessKey;
    }

    public function __destruct()
    {

    }
    
    protected function show ()
    {
        $html = "id=\"".$this->id."\" name=\"".$this->name."\" %s %s %s ";
        return $html;
    }

    protected function showLabel ()
    {
        $label = "<label for=\"".$this->id."\" ";
        $label .= trim($this->accessKey) != ""?"accesskey=\"".$this->accessKey."\" ":"";
        $label .= ">".$this->label."</label>";
        return $label;
    }

    protected function showExtra ()
    {
        $element = "";
        $element .= trim($this->tooltip) != ""?"title = \"".$this->tooltip."\" ":"";
        $element .= trim($this->tabindex) != ""?"tabindex = \"".$this->tabindex."\" ":"";
        $element .= trim($this->class) != ""?"class = \"".$this->class."\" ":"";
        $element .= trim($this->style) != ""?"style = \"".$this->style."\" ":"";
        return $element;
    }

    protected function showEvents ()
    {
        $element = "";
        $element .= trim($this->blurFunction) != ""?"onblur = \".$this->blurFunction.\" ":"";
        $element .= trim($this->changeFunction) != ""?"onchange = \".$this->changeFunction.\" ":"";
        $element .= trim($this->focusFunction) != ""?"onfocus = \".$this->focusFunction.\" ":"";
        $element .= trim($this->mouseoutFunction) != ""?"onmouseout = \".$this->mouseoutFunction.\" ":"";
        $element .= trim($this->mouseoverFunction) != ""?"onmouseover = \".$this->mouseoverFunction.\" ":"";
        $element .= trim($this->keypressFunction) != ""?"onkeypress = \".$this->keypressFunction.\" ":"";
        $element .= trim($this->selectFunction) != ""?"onselect = \".$this->selectFunction.\" ":"";
        return $element;
    }

    public function getTooltip ()
    {
        return $this->tooltip;
    }
    
    public function setTooltip ($tooltip) 
    {
        $this->tooltip = $tooltip;
    }

    public function onBlur($code)
    {
        $this->blurFunction = $code;
    }

    public function onChange($code)
    {
        $this->changeFunction = $code;
    }

    public function onClick($code)
    {
        $this->clickFunction = $code;
    }

    public function onFocus($code)
    {
        $this->focusFunction = $code;
    }

    public function onMouseOut($code)
    {
        $this->mouseoutFunction = $code;
    }

    public function onMouseOver($code)
    {
        $this->mouseoverFunction = $code;
    }

    public function onKeyPress($code)
    {
        $this->keypressFunction = $code;
    }

    public function onSelect($code)
    {
        $this->selectFunction = $code;
    }
    
}

?>
