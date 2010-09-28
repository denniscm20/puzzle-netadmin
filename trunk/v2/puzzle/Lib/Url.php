<?php
/*
 * Lib/Url.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the url creation and parameters retrieval
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Lib
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_Url {

    private $piece;

    private $page;

    private $event;

    private $identifier;

    private $friendly;

    /**
     * Class constructor
     * @access public
     * @param Boolean $friendly True if making use of friendly url notation; else False
     */
    public function __construct($friendly) {
        $this->friendly = $friendly;
        $this->page = null;
        $this->piece = null;
        $this->event = null;
        $this->identifier = null;
    }

    /**
     * Builds an URL
     * @access public
     * @param String $piece Piece Name
     * @param String $page Page Name
     * @param Event $event Event Name
     * @param mixed $identifier
     * @return String Built url.
     */
    public function build($piece, $page, $event = null, $identifier = null) {
        $this->page = $page;
        $this->piece = $piece;
        $this->event = $event;
        $this->identifier = $identifier;

        $url = "/index.php";

        if ($this->friendly === true) {
            $url .= "/{$this->piece}/{$this->page}";
            if ($this->event != null) {
                $url .= "/{$this->event}";
                $url .= ($this->identifier == null)?"":"/{$this->identifier}";
            }
        } else {
            $url .= "?Piece={$this->piece}&Page={$this->page}";
            if ($this->event != null) {
                $url .= "&Event={$this->event}";
                $url .= ($this->identifier == null)?"":"&Id={$this->identifier}";
            }
        }

        return $url;
    }

    /**
     * Fills up the object attributes making use of the parameters from the URL.
     * @access public
     */
    public function fill() {
        if ($this->friendly === true) {
            $url = $_SERVER['REQUEST_URI'];
            $parameters = substr($url, strpos($url, '/', 1) + 1);
            $parameters = explode('/', $parameters);
            if (count($parameters) >= 2) {
                $this->piece = $parameters[0];
                $this->page = $parameters[1];
                $this->event = isset($parameters[2])?$parameters[2]:null;
                $this->identifier = isset($parameters[3])?$parameters[3]:null;
            }
        } else {
            $this->piece = filter_input(INPUT_GET, "Piece", FILTER_SANITIZE_STRING);
            $this->page = filter_input(INPUT_GET, "Page", FILTER_SANITIZE_STRING);
            $this->event = filter_input(INPUT_GET, "Event", FILTER_SANITIZE_STRING);
            $this->identifier = filter_input(INPUT_GET, "Id", FILTER_SANITIZE_STRING);
        }
    }

    public function getPiece() {
        return $this->piece;
    }

    public function getPage() {
        return $this->page;
    }

    public function getEvent() {
        return $this->event;
    }

    public function getIdentifier() {
        return $this->identifier;
    }
    
}
?>
