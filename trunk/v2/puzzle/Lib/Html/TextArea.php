<?php

/*
 * Lib/Html/TextArea.php - Copyright 2009 Dennis Cohn Muroy
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
class Lib_Html_TextArea extends Lib_Html_Html {

    private $rows = 0;
    private $cols = 0;
    private $maxlength = 0;
    private $wrap = false;

    public function __construct($id, $value, $label, $tabindex = 0, $accessKey = '')
    {
        parent::__construct($id, $value, $label, $tabindex, $accessKey);
    }

    protected function show()
    {
        $basic = parent::show();
        $extra = $this->showExtra();
        $events = $this->showEvents();
        $label = "<span class=\"label\">".$this->showLabel()."</span>";
        $own  = "rows = \"".$this->rows."\" ";
        $own .= "cols = \"".$this->cols."\" ";
        $own .= "wrap = \"".$this->wrap === true?"on":"off"."\" ";
        $textarea = sprintf($basic, $own, $events);
        $textarea = "<span class=\"field\"><textarea ".$textarea." >".$this->value."</textarea></span>";

        return $label.$textarea;
    }

    public function showTextArea($rows, $cols, $wrap=false, $maxlength=0, $tooltip= "", $class = "", $style = "")
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->wrap = $wrap;
        $this->maxlength = $maxlength;
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        return $element;
    }
}

?>
