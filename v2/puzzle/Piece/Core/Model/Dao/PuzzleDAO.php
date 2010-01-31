<?php
/*
 * Core/Model/Dao/PuzzleDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the core of the puzzle application.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Dao
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Dao_PuzzleDAO extends Base_DAO
{
    
    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Inserts a new object in the database.
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return Boolean
     */
    public function insert()
    {
        $this->query = "INSERT INTO Puzzle (hostname, dns1, dns2, forward)
            VALUES (?, ?, ?, ?)";
        $this->parameters = array($this->object->Hostname, $this->object->Dns1,
            $this->Dns2, $this->Forward);
        $this->executeQuery();
        return $this->getLastId();
    }

    /**
     * Updates an existing object in the database
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return Boolean
     */
    public function update()
    {
        $this->query = "UPDATE Puzzle SET hostname = ?, dns1 = ?, dns2 = ?,
            forward = ? WHERE id = ?";
        $this->parameters = array($this->object->Hostname, $this->object->Dns1,
            $this->Dns2, $this->Forward,$this->object->Id);
        return $this->executeQuery();
    }

    /**
     * Deletes an existing object from the database
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return Boolean
     */
    public function delete()
    {
        $this->query = "DELETE FROM Puzzle WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return $this->executeQuery();
    }

    /**
     * Selects an object from the database
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return Base_Model
     */
    public function select()
    {
        $this->query = "SELECT id, hostname, dns1, dns2, forward FROM Puzzle WHERE id = ?";
        $this->parameters = array($this->object->Id);
        $result = $this->selectQuery();
        return (count($result) > 0)? $result[0] : null;
    }

    /**
     * Lists a range of elements from the database.
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @param Integer $start first element of the list to retrieve
     * @param Integer $range Number of elements to retrieve
     * @return array
     */
    public function listElements($start, $range = self::LIMIT_DEFAULT)
    {
        $this->query = "SELECT id, hostname, dns1, dns2, forward FROM Puzzle";
        $this->limitQuery($start, $range);
        $this->parameters = array();
        return $this->selectQuery();
    }
}
?>