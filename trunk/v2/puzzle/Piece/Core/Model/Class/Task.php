<?php
/*
 * Core/Model/Class/Task.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_BASE.'Class.php';

/**
 * Class that represents all the actions that a user can perform
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Task extends Base_Class
{
    /**
     * The name of the task.
     * @access private
     * @var String
     */
    private $name;

    /**
     * The name of the page this task is related to.
     * @access private
     * @var String
     */
    private $page;

    /**
     * The name of the event this task is related to.
     * @access private
     * @var String
     */
    private $event;

    public function __construct() {
        parent::__construct();
        $this->name = "";
        $this->page = "";
        $this->event = "";
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function getName() {
        return $this->name;
    }

    public function getPage() {
        return $this->page;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setName($name) {
        if (Lib_Validator::validateString($name, 30)) {
            $this->name = $name;
        }
    }

    public function setPage($page) {
        if (Lib_Validator::validateString($page, 30)) {
            $this->page = $page;
        }
    }

    public function setEvent($event) {
        if (Lib_Validator::validateString($event, 10)) {
            $this->event = $event;
        }
    }

}
?>
