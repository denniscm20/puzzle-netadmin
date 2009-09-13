<?php
/*
 * Lib/Html/Table.php - Copyright 2009 Dennis Cohn Muroy
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

require_once(LIB_PATH.'Html/Html.php');

/**
 * Class that represents an HTML table.
 * @package Lib
 * @subpackage Html
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_Html_Table extends Html
{
    
    private $header = array();
    private $footer = array();
    private $rows = array();
    
    public function __construct($id, $class, $style)
    {
        parent::__construct($id, 0, $class, $style);
        $this->header = array();
        $this->footer = array();
        $this->rows = array();
    }
    
    public function __destruct()
    {
        foreach ($this->header as $item) {
            unset($item);
        }
        unset($this->header);
        foreach ($this->footer as $item) {
            unset($item);
        }
        unset($this->footer);
        foreach ($this->rows  as $item) {
            unset($item);
        }
        unset($this->rows);
        parent::__destruct();
    }
    
    public function setHeader($header)
    {
        if (is_array($header)){
            $this->header = $header;
        }
    }
    
    public function setFooter($footer)
    {
        if (is_array($footer)){
            $this->footer = $footer;
        }
    }
    
    public function addRow( $row, $position = -1 )
    {
        if (is_numeric($position) && is_array($row)) {
            if ($position === -1) {
                $this->rows[] = $row;
            } else {
                $tempArray = array();
                foreach ($this->rows as $tmpRow) {
                    $tempArray[] = $tmpRow;
                }
                $tempArray[] = $row;
                $this->rows = $tempArray;
            }
        }
    }
    
    public function removeRow( $number )
    {
        if (is_numeric($number)) {
            $count = count($this->rows);
            $tempArray = array();
            for ($i = 0; $i < $count; $i++) {
                if ($i != $number) {
                    $tempArray = $this->rows[$i];
                }
            }
            $this->rows = $tempArray;
        }
    }
    
    public function show()
    {
        $header  = "<thead><tr>";
        foreach ($this->header as $head) {
            $header .= "<th>".$head."</th>";
        }
        $header .= "</tr></thead>";
        $footer  = "<tfoot><tr>";
        foreach ($this->footer as $foot) {
            $header .= "<td>".$foot."</td>";
        }
        $footer .= "</tr></tfoot>";
        $rows  = "<tbody>";
        foreach ($this->rows as $row) {
            $rows .= "<tr>";
            foreach ($row as $item) {
                $rows .= "<td>".$item."</td>";
            }
            $rows .= "</tr>";
        }
        $rows .= "</tbody>";
        $table = "<table id=\"{$this->id}\" class=\"{$this->class}\" style=\"{$this->style}\">";
        $table .= $header.$rows.$footer;
        $table .= "</table>";
        return $table;
    }
}

?>
