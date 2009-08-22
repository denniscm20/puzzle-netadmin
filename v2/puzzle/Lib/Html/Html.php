<?php

/*
 * Lib/Html/Html.php - Copyright 2009 Dennis Cohn Muroy
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

    protected function __construct($id, $tabindex = 0, $class = "", $style = "")
    {
        $this->id = $id;
        $this->name = $id;
        $this->label = $label;
        $this->tabindex = $tabindex;
        $this->class = $class;
        $this->style = $style;
    }

    public function __destruct()
    {

    }
    
    public function __get($name) 
    {
        $function = "get".$name;
        if (method_exists($this, $function)) {
            return $this->{$function}();
        } else {
            throw new Exception($name ." is not a valid property");
        }
    }
    
    public function __set($name, $value) 
    {
        $function = "set".$name;
        if (method_exists($this, $function)) {
            $this->{$function}($value);
        } else {
            throw new Exception($name ." is not a valid property");
        }
    }

    public function getId () 
    {
        return $this->id;
    }
    
    public function setId ($id)
    {
        $this->id = $id;
    }
    
    public function getName ()
    { 
        return $this->name;
    }
    
    public function setName ($name)
    { 
        $this->name = $name;
    }
    
    public function getAccessKey ()
    {
        return $this->accessKey;
    }
    
    public function setAccessKey ($accessKey)
    {
        $this->accessKey = $accessKey;
    }
    
    public function getTooltip ()
    {
        return $this->tooltip;
    }
    
    public function setTooltip ($tooltip) 
    {
        $this->tooltip = $tooltip;
    }
    
    public function getTabindex ()
    {
        return $this->tabindex;
    }
    
    public function setTabindex ($tabindex)
    {
        $this->tabindex = $tabindex;
    }

    public function getClass () 
    {
        return $this->class;
    }
    
    public function setClass ($class)
    {
        $this->class = $class;
    }
    
    public function getStyle ()
    {
        return $this->style;
    }
    
    public function setStyle ($style)
    {
        $this->style = $style;
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

    protected abstract function show();
    
}

?>
