<?php
/*
 * Core/Model/Dao/SubnetDAO.php - Copyright 2010 Dennis Cohn Muroy
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
 * Class that implements the subnet database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_SubnetDAO extends Base_DAO
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
        $this->query = "SELECT id, name, ip4, ip6, mask4, mask6 FROM Subnet WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function save($interface_id)
    {
        if ($this->object->Id > 0) {
            $this->query = "INSERT INTO Subnet (id_interface, name, description, ip4, ip6, mask4, mask6)
                VALUES (?,?,?,?,?,?,?)";
            $this->parameters = array($interface_id, $this->object->Name,
                $this->object->Description, $this->object->Ip4,
                $this->object->Ip6, $this->object->Mask4, $this->object->Mask6);
        } else {
            $this->query = "UPDATE Subnet SET name = ?, description = ? WHERE id = ?";
            $this->parameters = array($this->object->Name, $this->object->Description, $this->object->Id);
        }
        return parent::save();
    }

    public function delete()
    {
        $this->object = $this->load();
        if (count($this->object->NodeList) > 0) {
            $this->query = "DELETE FROM Subnet WHERE id = ?";
            $this->parameters = array($this->object->Id);
            return parent::delete();
        }
        return false;
    }

    public function selectListByInterface($interface_id, $start)
    {
        $this->query = "SELECT id, name, ip4, ip6, mask4, mask6 FROM Subnet
            WHERE id_interface = ?";
        $this->parameters = array($interface_id);
        return parent::listObjects($start, DEFAULT_LIST_LIMIT);
    }

    protected function loadObjectReferences($object, $result)
    {
        $daoName = Lib_Helper::getDao('Core', 'Node');
        $className = Lib_Helper::getClass('Core', 'Node');
        $daoNode = new $daoName ($className);
        $object->NodeList = $daoNode->selectListBySubnet($object->Id, 0);

        return $object;
    }

}
?>
