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
    private $piece;
    private $page;

    public function  __construct($piece, $page)
    {
        $this->page = $page;
        $this->piece = $piece;
    }

    public function show()
    {
        $homeLink = "<a href=\"\/\">".BREADCRUMB_HOME."</a>";
        $pieceLink = $this->piece;
        $pageLink = $this->page;
        $breadcrumb = $homeLink.BREADCRUMB_SEPARATOR.$pieceLink.BREADCRUMB_SEPARATOR.$pageLink;
        return $breadcrumb;
    }
}

?>