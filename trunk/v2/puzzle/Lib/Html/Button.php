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

    public const TYPE_SUBMIT = 0;
    public const TYPE_RESET = 1;
    public const TYPE_GENERAL = 2;

    private $type = "";

    public function __construct($id, $value, $type, $tabindex = 0)
    {
        parent::__construct($id, $value, "", $tabindex);
        switch ($type) {
            case 0: $this->type = "submit"; break;
            case 1: $this->type = "reset"; break;
            case 2:
            default: $this->type = "button"; break;
        }
    }

    public function show()
    {
        $basic = $this->getBasic();
        $events = $this->getEvents();
        $own = "type=\"{$this->type}\" value = \"{$this->value}\" ";
        return "<input ".sprintf($basic, $own, $extra, $events)." />";
    }

    public function onClick($code)
    {
        $this->events["onclick"] = $code;
    }
    
}
?>
