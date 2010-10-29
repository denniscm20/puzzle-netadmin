<?php
/*
 * Core/Model/Dao/PieceDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the piece database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_PieceDAO extends Base_DAO
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
        $this->query = "SELECT id, name, enable, description, component FROM Piece WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function save()
    {
        if ($this->object->Id > 0) {
            $this->query = "INSERT INTO Piece (name, enable, description, component)
                VALUES (?, ?, ?, ?)";
            $this->parameters = array($this->object->Name, $this->object->Enable,
                $this->object->Description, $this->object->Component);
        } else {
            $this->query = "UPDATE Piece SET enable = ? WHERE id = ?";
            $this->parameters = array($this->object->Enable, $this->object->Id);
        }
        return parent::save();
    }

    public function delete()
    {
        $daoName = Lib_Helper::getDao('Core', 'Task');
        $dao = new $daoName(Lib_Helper::getClass('Core', 'Task'));
        if ($dao->deleteByPiece($this->object->Id) === true) {
            $this->query = "DELETE FROM Piece WHERE id = ?";
            $this->parameters = array($this->object->Id);
            return parent::delete();
        }
        return false;
    }

    public function selectListByTask($privilege_id)
    {
        $this->query = "SELECT A.id, A.name, A.enable, A.description, A.component
            FROM Piece AS A
            Left JOIN Task AS B
            ON (A.id = B.id_piece)
            WHERE B.id = ?";
        $this->parameters = array($privilege_id);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    protected function loadObjectReferences($object, $result)
    {
        $daoName = Lib_Helper::getDao('Core', 'Task');
        $taskDAO = new $daoName('Core_Model_Class_Task');
        $object->PrivilegeList = $taskDAO->selectListByPiece($this->object->Id);
        return $object;
    }

}
?>
