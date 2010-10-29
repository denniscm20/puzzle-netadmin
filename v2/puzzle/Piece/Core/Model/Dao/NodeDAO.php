<?php
/*
 * Core/Model/Dao/NodeDAO.php - Copyright 2010 Dennis Cohn Muroy
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
 * Class that implements the node database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_NodeDAO extends Base_DAO
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
        $this->query = "SELECT id, name, description, ip4, ip6, FROM Node WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function save($subnet_id)
    {
        if ($this->object->Id > 0) {
            $this->query = "INSERT INTO Node (id_subnet, name, description, ip4, ip6)
                VALUES (?,?,?,?,?,?)";
            $this->parameters = array($subnet_id, $this->object->Name, $this->object->Description, 
                $this->object->Ip4, $this->object->Ip6);
            return parent::save();
            if ($this->object->Id === false || $this->object->Id === 0) {
                return false;
            }
        }
    }

    public function delete()
    {
        $this->query = "DELETE FROM Node WHERE id = ?";
        $this->parameters = array($this->object->Id);
        if (parent::delete() === true) {
            $this->query = "DELETE FROM Service_x_Node WHERE id_node = ?";
            $this->parameters = array($this->object->Id);
            return parent::delete();
        }
        return false;
    }

    public function selectListByService($service_id)
    {
        $this->query = "SELECT A.id, A.name, A.description, A.ip4, A.ip6
            FROM Node AS A
            LEFT JOIN Service_x_Node AS B 
            ON (A.id = B.id_node)
            WHERE B.id_service = ?";
        $this->parameters = array($service_id);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    public function selectListBySubnet($subnet_id, $start)
    {
        $this->query = "SELECT id, name, description, ip4, ip6 FROM Node
            WHERE id_subnet = ?";
        $this->parameters = array($subnet_id);
        return parent::listObjects($start, DEFAULT_LIST_LIMIT);
    }

    protected function loadObjectReferences($object, $result)
    {
        $daoName = Lib_Helper::getDao('Core', 'Service');
        $className = Lib_Helper::getClass('Core', 'Service');
        $daoService = new $daoName ($className);
        $object->ServiceList = $daoService->selectListByNode($object->Id);

        return $object;
    }

}
?>
