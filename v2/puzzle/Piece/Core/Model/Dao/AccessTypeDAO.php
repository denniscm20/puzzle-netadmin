<?php
/*
 * Core/Model/Dao/AccessTypeDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the access type database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_AccessTypeDAO extends Base_DAO
{
    public function  __construct($object)
    {
        parent::__construct($object);
    }

    public function  __destruct()
    {
        parent::__destruct();
    }

    public function load()
    {
        $this->query = "SELECT id, name, description FROM AccessType WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    protected function loadObjectReferences($object, $result)
    {
        return $object;
    }

}
?>
