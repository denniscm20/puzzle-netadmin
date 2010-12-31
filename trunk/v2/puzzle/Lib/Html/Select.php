<?php

/*
 * Lib/Html/Select.php - Copyright 2009 Dennis Cohn Muroy
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
class Lib_Html_Select extends Lib_Html_Html {

    private $multiple = false;
    private $size = 0;
    private $attributeName = "";
    private $attributeId = "";

    public function __construct($id, $value, $label, $attributeName = "", $attributeId = "", $tabindex = 0, $accessKey = '')
    {
        parent::__construct($id, $value, $label, $tabindex, $accessKey);
        $this->multiple = false;
        $this->attributeName = $attributeName;
        $this->attributeId = $attributeId;
    }

    public function show()
    {
        $basic = $this->getBasic();
        $events = $this->getEvents();
        $label = "<span class=\"label\">".$this->showLabel()."</span>";
        $own = $this->multiple===true?"multiple=\"yes\" size=\"".$this->size."\"":"";
        $select = sprintf($basic, $own, $events);
        $select = "<span class=\"field\"><select ".$select." >\n%s</select>\n</span>";
        return $label.$select;
    }

    protected function showOptions($selectedID = 0)
    {
        $options = $this->multiple === false?"<option value=\"0\">Seleccione</option>\n":"";
        if (is_array($this->value)) {
            $count = count($this->value);
            for ($i = 0; $i < $count; $i++) {
                $object = $pValue[$i];
                $options .= "<option value=\"";
                if (is_object($object)) {
                    $options .= $object->{$this->attributeId}."\" ";
                    $options .= ($object->{$this->attributeId} == $selectedID?"selected = \"selected\"":"").">";
                    $options .= $object->{$this->attributeName};
                } else {
                    $options .= $object."\" ";
                    $options .= ($i == $selectedID?"selected = \"selected\"":"").">";
                    $options .= $object;
                }
            }
        }
        $options .= "</option>\n";
    }

    public function showComboBox($selectedID = "0", $tooltip= "", $class = "", $style = "")
    {
        $this->type = false;
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $element = $this->show();
        $element = sprintf($element,$this->showOptions($selectedID));
        return $element;
    }

    public function showItemList($selectedID = "0", $tooltip= "", $class = "", $style = "")
    {
        $this->type = true;
        $this->tooltip = $tooltip;
        $this->style = $style;
        $this->class = $class;
        $this->size = $size;
        $element = $this->show();
        $element = sprintf($element,$this->showOptions($selectedID));
        return $element;

        
        if (is_array($pValue)) {
            for ($i = 0; $i < count($pValue); $i++) {
                $objeto = $pValue[$i];
                $lList .= "<option value=\"".$objeto->$pValueName."\">".$objeto->$pText."</option>\n";
            }
        }
        $lList .= "</select>";

        return $lList;
    }

}

?>
