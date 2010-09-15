<?php
/*
 * Core/Model/Dao/ServiceDAO.php - Copyright 2010 Dennis Cohn Muroy
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
 * Class that implements the service database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_ServiceDAO extends Base_DAO
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
        $this->query = "SELECT id, name FROM Service WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function selectListByNode($node_id)
    {
        $this->query = "SELECT A.id, A.name
            FROM Service AS A
            LEFT JOIN Service_x_Node AS B
            ON A.id = B.id_service 
            WHERE id_node = ?";
        $this->parameters = array($node_id);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    protected function loadObjectReferences($object, $result)
    {
        $daoName = Lib_Helper::getDao("Core", "Port");
        $className = Lib_Helper::getClass("Core", "Port");
        $portDAO = new $daoName($className);
        $object->PortList = $portDAO->selectListByService($object->Id);

        $daoName = Lib_Helper::getDao("Core", "Protocol");
        $className = Lib_Helper::getClass("Core", "Protocol");
        $protocolDAO = new $daoName($className);
        $object->ProtocolList = $protocolDAO->selectListByService($object->Id);
        
        return $object;
    }

}
?>
