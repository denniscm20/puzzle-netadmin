<?php

/*
 * Base/Breadcrumb.php - Copyright 2009 Dennis Cohn Muroy
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

class Lib_Breadcrumb
{
    private $path;
    private $current;

    public function  __construct($current)
    {
        $this->path = array();
        $this->current = $current;
    }

    public function add($link, $page) {
        $this->path[$link] = $page;
    }

    public function show()
    {
        $breadcrumb = "<a href=\"\/\">".BREADCRUMB_HOME."</a>";
        foreach ($this->path as $link => $page) {
            $breadcrumb .= BREADCRUMB_SEPARATOR."<a href=\"".$link."\">".$page."</a>";
        }
        $breadcrumb .= BREADCRUMB_SEPARATOR.$this->current;
        return $breadcrumb;
    }
}

?>