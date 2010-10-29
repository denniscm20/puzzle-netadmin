<?php

/*
 * Core/Model/Dao/PrivilegeDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the Privilege database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_PrivilegeDAO extends Base_DAO
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
        $this->query = "SELECT id, id_piece, name, page, event FROM Privilege WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function save()
    {
        $this->query = "INSERT INTO Privilege (name, page, event) VALUES (?, ?, ?)";
        $this->parameters = array($this->object->Name, $this->object->Page, $this->object->Event);
        return parent::save();
    }

    public function delete()
    {
        $this->query = "DELETE FROM Role_x_Privilege WHERE id_privilege = ?";
        $this->parameters = array($this->object->Id);
        if (parent::delete() === true) {
            $this->query = "DELETE FROM Privilege WHERE id = ?";
            $this->parameters = array($this->object->Id);
            return parent::delete();
        }
        return false;
    }

    public function deleteByPiece($piece_id)
    {
        $this->query = "DELETE FROM Role_x_Privilege AS A LEFT JOIN Privilege AS B
            ON (A.id_privilege = B.id) WHERE B.id_piece = ?";
        $this->parameters = array($piece);
        if (parent::delete() === true) {
            $this->query = "DELETE FROM Privilege WHERE id_piece = ?";
            $this->parameters = array($piece_id);
            return parent::delete();
        }
        return false;
    }

    public function selectListByRole($role_id)
    {
        $this->query = "SELECT a.id, a.id_piece, a.name, a.page, a.event FROM Privilege AS a
            LEFT JOIN Role_x_Privilege AS b ON (a.id = b.id_role) WHERE b.id_role = ?";
        $this->parameters = array($role_id);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    public function selectListByNotRole($role_id)
    {
        $this->query = "SELECT a.id, a.id_piece, a.name, a.page, a.event FROM Privilege AS a
            LEFT JOIN Role_x_Privilege AS b ON (a.id = b.id_role) WHERE b.id_role <> ?";
        $this->parameters = array($role_id);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    public function selectListByPiece($piece_id)
    {
        $this->query = "SELECT id, id_piece, name, page, event FROM Privilege WHERE id_piece = ?";
        $this->parameters = array($piece_id);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    public function selectListByRoleAndPieceAndPageAndEvent($role_id, $piece)
    {
        $this->query = "SELECT B.id, B.name
            FROM Role_x_Privilege AS A
            LEFT JOIN Privilege AS B
            ON (A.id_privilege = B.id)
            LEFT JOIN Pieve AS C
            ON (C.id = B.id_piece)
            WHERE B.name = ? AND B.page = ? AND B.event = ? AND A.id_role = ?";
        $this->parameters = array($piece, $this->object->Page, $this->object->Event, $role_id);
        return parent::listObjects(0, 1);
    }

    public function selectList($start)
    {
        $this->query = "SELECT id, id_piece, name, page, event FROM Privilege";
        return $this->listObjects($start, DEFAULT_LIST_LIMIT);
    }

    protected function loadObjectReferences($object, $result)
    {
        return $object;
    }
}
?>
