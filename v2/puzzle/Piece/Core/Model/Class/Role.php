<?php
/*
 * Core/Model/Class/Role.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that represents a role registered in the system
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Class
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Role extends Base_Class
{
    /**
     * Name of the role
     * @access private
     * @var String
     */
    private $name;

    /**
     * Description of the role
     * @access private
     * @var String
     */
    private $description;

    /**
     * List of tasks assigned to the current role.
     * @access private
     * @var Array
     */
    private $privilegeList;

    public function __construct()
    {
        parent::__construct();
        $this->name = "";
        $this->description = "";
        $this->privilegeList = array();
    }

    public function __destruct()
    {
        parent::__destruct();
        foreach ($this->privilegeList as $task) {
            unset($task);
        }
        unset($this->privilegeList);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (Lib_Validator::validateString($name, 30)) {
            $this->name = $name;
        }
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if (Lib_Validator::validateString($description, 200)) {
            $this->description = $description;
        }
    }

    public function getPrivilegeList() {
        return $this->privilegeList;
    }

    public function setPrivilegeList($privilegeList) {
        if (Lib_Validator::validateArray($privilegeList, "Core_Model_Class_Privilege")) {
            $this->privilegeList = $privilegeList;
        }
    }
}
?>
