<?php
/*
 * Core/Model/Dao/ValidIpDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the valid ip database interface.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Model_Dao_ValidIpDAO  extends Base_DAO
{
    public function __construct($object)
    {
        parent::__construct($object);
        Lib_Helper::getClass("Core", "ValidIp");
    }

    public function  __destruct() {
        parent::__destruct();
    }
    
    public function save()
    {
        $this->query = "INSERT INTO ValidIp (ip, ipv4) VALUES (?, ?)";
        $this->parameters = array($this->object->Ip, $this->object->Ipv4);
        return parent::save();
    }

    public function delete()
    {
        $this->query = "DELETE FROM ValidIp WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::delete();
    }

    public function listObjects($start, $range  = self::LIMIT_DEFAULT)
    {
        $this->query = "SELECT id, ip, ipv4 FROM ValidIp";
        $this->parameters = array();
        return parent::listObjects($start, $range);
    }

    public function load()
    {
        $this->query = "SELECT id, ip, ipv4 FROM ValidIp WHERE id = ?";
        $this->parameters = array($this->object->Id);
        return parent::load();
    }

    public function selectByIp()
    {
        $this->query = "SELECT id, ip, ipv4 FROM ValidIp WHERE ip = ?";
        $this->parameters = array($this->object->Ip);
        return parent::load();
    }

    protected function loadObjectReferences($object, $result)
    {
        return $object;
    }
}
?>
