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
        return 0;
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
        return false;
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
        return false;
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
        return $this->loadObject(null);
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
        return array($this->select());
    }

    protected function loadObject($result)
    {
        $object = new Core_Model_Class_Puzzle();
        
        $interface = new Core_Model_Class_Interface();
        $interfaceDAO = new Core_Model_Dao_Interface($interface);
        $object->InterfaceList = $interfaceDAO->listElements(0);

        return $object;
    }
}
?>