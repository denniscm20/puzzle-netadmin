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

    private $type = "";

    public function __construct($id, $value, $tabindex = 0)
    {
        parent::__construct($id, $value, "", $tabindex);
        $this->type = "";
    }

    protected function show()
    {
        $basic = parent::show();
        $extra = $this->showExtra();
        $events = $this->showEvents();
        $own = "type=\"{$this->type}\" value = \"{$this->value}\" ";
        $input = sprintf($basic, $own, $extra, $events);
        $input = "<span class=\"field\"><input ".$input." /></span>";
        return $input;
    }

    public function showSubmitButton($tooltip= "", $class = "", $style = "")
    {
        $this->type = "submit";
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        return $element;
    }

    public function showResetButton($tooltip= "", $class = "", $style = "")
    {
        $this->type = "reset";
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        return $element;
    }

    public function showButton ($tooltip= "", $class = "", $style = "")
    {
        $this->type = "button";
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        return $element;
    }
    
}
?>
