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
   
    public function update()
    {
    }
    
    public function listElements($start, $range = self::LIMIT_DEFAULT)
    {
    }

    protected function loadObject($result)
    {
        $account = parent::loadObject($result);
        $account->Role->Id = $result["id_role"];
        return $account;
    }
    
    public function insert()
    {
    }

    public function delete()
    {
        $this->query = "DELETE FROM Account WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return $this->executeQuery();
    }
    
    public function select()
    {
        $this->query = "SELECT id, id_role, username, password, salt, changePassword, enabled ".
                       "FROM Account WHERE id = ?";
        $this->parameters = array($this->object->Id);
        $this->selectQuery();
    }

    public function selectByUsernameAndEnabled ()
    {
        $this->query = "SELECT id, id_role, username, password, salt, changePassword ".
                       "FROM Account WHERE username = ? and enabled = ?";
        $this->parameters = array($this->object->Username, $this->object->Enabled);
        $this->selectQuery();
    }

}
?>