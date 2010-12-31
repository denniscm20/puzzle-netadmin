<?php
/*
 * Core/Model/Dao/RoleDAO.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_BASE.'DAO.php';

/**
 * Class that implements the role database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_RoleDAO extends Base_DAO
{

    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function load()
    {
        $this->query = "SELECT name, description FROM Role WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function delete()
    {
        $this->query = "DELETE FROM Role_x_Privilege WHERE id_role = ?";
        $this->parameters = array($this->object->Id);
        if (parent::delete() === true) {
            $this->query = "DELETE FROM Role WHERE id = ?";
            $this->parameters = array($this->object->Id);
            return parent::delete();
        }
        return false;
    }

    public function save()
    {
        if ($this->object->Id) {
            $this->query = "INSERT INTO Role (name, description) VALUES (?, ?)";
            $this->parameters = array($this->object->Name, $this->object->Description);
        } else {
            $this->query = "UPDATE Role SET description = ? WHERE id = ?";
            $this->parameters = array($this->object->Description, $this->object->Id);
        }
        return parent::save();
    }

    public function selectListByName($start)
    {
        $this->query = "SELECT name, description FROM Role WHERE name LIKE ?%";
        $this->parameters = array($this->object->Name);
        return parent::listObjects($start, DEFAULT_LIST_LIMIT);
    }

    protected function loadObjectReferences($object, $result)
    {
        $daoName = Lib_Helper::getDao('Core', 'Privilege');
        $className = Lib_Helper::getClass('Core', 'Privilege');
        $privilegeDAO = new $daoName($className);
        $object->PrivilegeList = $privilegeDAO->selectListByRole($object->Id);
        return $object;
    }
}
?>