<?php
/*
 * Core/Controller/ServerController.php - Copyright 2010 Dennis Cohn Muroy
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

require_once PATH_BASE.'Controller.php';

/**
 * Class that implements the methods of the server controller class.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Controller
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class ServerController extends Base_Controller
{
    private $server = null;
    
    private $serverDAO = null;

    protected function __construct()
    {
        parent::__construct();
        Lib_Helper::getClass("Core", "Puzzle");
        Lib_Helper::getDAO("Core", "Puzzle");
        $this->server = new Core_Model_Class_Puzzle();
        $this->serverDAO = new Core_Model_Dao_PuzzleDAO($this->server);
    }

    /**
     * Class destructor.
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return void
     */
    public function __destruct()
    {
        parent::__destruct();
        unset($this->server);
        unset($this->serverDAO);
    }

    protected function call($event)
    {
        switch ($event) {
            case "load":
                break;
            case "enable":
                $event = "enableForward";
                break;
            case "disable":
                $event = "disableForward";
                break;
            default: $event = DEFAULT_EVENT;
        }
        return $event;
    }

    protected function load()
    {
        $this->server = $this->serverDAO->load();
    }

    protected function enableForward()
    {
        $this->load();
        $this->serverDAO->enableForward();
        $this->server->Forward = true;
    }

    protected function disableForward()
    {
        $this->load();
        $this->serverDAO->disableForward();
        $this->server->Forward = false;
    }

    protected function filterInput()
    {

    }

    protected function loadElements()
    {
        $this->add("server", $this->server);
        return;
    }
}
?>
