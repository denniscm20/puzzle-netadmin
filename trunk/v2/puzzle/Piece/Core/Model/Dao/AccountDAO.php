<?php

/*
 * Core/Model/Dao/AccountDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the account database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_AccountDAO extends Base_DAO {

    public function  __construct($object) {
        parent::__construct($object);
    }

    public function  __destruct() {
        parent::__destruct();
    }
   
    public function save()
    {
        if ($this->object->Id > 0) {
            $this->query = "INSERT INTO account
                (username, email, token, salt, password, changePassword, enabled,
                tokenDate, createdDate, modifiedDate) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->parameters = array();
        } else {
            $this->query = "UPDATE account SET email = ?, changePassword = ?, 
                modifiedDate = ? WHERE id = ?";
            $this->parameters = array($this->object->Email,
                $this->object->ChangePassword, $this->object->ModifiedDate,
                $this->object->Id);
        }
        return parent::save();
    }

    public function savePassword()
    {
        $this->query = "UPDATE account SET salt = ?, password = ?, modifiedDate = ? WHERE id = ?";
        $this->parameters = array($this->object->Salt, $this->object->Password,
                $this->object->Id);
        return parent::save();
    }

    public function saveToken()
    {
        $this->query = "UPDATE account SET token = ?, tokenDate = ? WHERE id = ?";
        $this->parameters = array($this->object->Token, $this->object->TokenDate, $this->object->Id);
        return parent::save();
    }

    public function disable()
    {
        $this->query = "UPDATE account SET enabled = ?, modifiedDate = ? WHERE id = ?";
        $this->parameters = array($this->object->Enabled, $this->object->ModifiedDate, $this->object->Id);
        return parent::save();
    }

    public function load()
    {
        $this->query = "SELECT id, id_role, username, password, salt, changePassword, enabled ".
                       "FROM Account WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function selectByUsernameAndEnabled ()
    {
        $this->query = "SELECT id, id_role, username, password, salt, changePassword ".
                       "FROM Account WHERE username = ? and enabled = ?";
        $this->parameters = array($this->object->Username, $this->object->Enabled);
        return parent::load();
    }

    protected function loadObjectReferences($object, $result) {
        $className = Lib_Helper::getDao("Core", "Role");
        $object->Role->Id = $result["id_role"];
        $roleDAO = new $className($object->Role);
        $object->Role = $roleDAO->select();
        return $object;
    }

}
?>
