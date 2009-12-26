<?php

/*
 * Core/Model/Dao/AccessLogDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the access log  database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_AccessLogDAO extends Base_DAO {

    public function  __construct($object) {
        parent::__construct($object);
        Lib_Helper::getClass("Core", "AccessLog");
    }

    public function  __destruct() {
        parent::__destruct();
    }

    public function listElements($start, $range = Base_DAO::LIMIT_DEFAULT)
    {
        $this->query = "SELECT A.username, A.ip, A.date || \" \" || A.time AS `Datetime`, B.description ".
                       "FROM AccessLog A ".
                       "LEFT JOIN AccessType B ".
                       "ON (A.id_access_type = B.id)";
        $this->parameters = array();
        $this->limitQuery($start, $range);
        return $this->selectQuery();
    }
    
    public function delete() {
        return false;
    }
    
    public function update() {
        return false;
    }
    
    public function insert() {
        $this->query = "INSERT INTO AccessLog (username, ip, date, time, id_access_type) ".
                       "VALUES (?, ?, ?, ?, ?)";
        $date = date("Y-m-d", strtotime($this->object->Datetime));
        $time = date("H:i:s", strtotime($this->object->Datetime));
        $this->parameters = array($this->object->Username, $this->object->Ip,
            $this->object->Username, $date, $time, $this->object->AccessType);
        return $this->executeQuery();
    }

    public function select() {
    }

    public function selectByAccessType() {
    }

    public function selectByUsername() {
    }

    public function selectByDate() {
    }
    
}
?>
