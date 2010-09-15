<?php
/*
 * Nmap/Model/Dao/NmapDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the nmap database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Nmap
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Nmap_Model_Dao_NmapDAO extends Base_DAO
{
    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function __destruct()
    {
        parent::__destruct();
    }
    
    public function selectList($start)
    {
        $this->query = "SELECT id, scanDate, id_account_scanner, options
            FROM Nmap";
        $this->parameters = array();
        return $this->listObjects($start, DEFAULT_LIST_LIMIT);
    }
    
    public function selectListByTimestamp($startTime, $endTime)
    {
        $this->query = "SELECT id, scanDate, id_account_scanner, options
            FROM Nmap WHERE scanDate >= ? AND scanDate <= ?";
        $this->parameters = array($startTime, $endTime);
        return $this->listObjects($start, DEFAULT_LIST_LIMIT);
    }
    
    public function save()
    {
        $this->query = "INSERT INTO Nmap (scanDate, id_account_scanner, options) VALUES (?, ?, ?)";
        $this->parameters = array($this->object->ScanDate, $this->object->Account->Id, $this->object->Options);
        return parent::save();
    }

    protected function loadObjectReferences($object, $result)
    {
        $daoName = Lib_Helper::getDao("Core", "Account");
        $object->Account->Id = $result['id_account_scanner'];
        $accountDAO = new $daoName($object->Account);
        $object->Account = $accountDAO->load();
        return $object;
    }

}
?>
