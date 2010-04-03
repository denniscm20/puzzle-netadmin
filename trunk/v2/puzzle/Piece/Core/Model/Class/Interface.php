<?php
/*
 * Core/Model/Class/Interface.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_BASE.'Class.php';

/**
 * Class that implements a network interface in the system.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Class
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Interface extends Base_Class
{

    private $subnetList = array();
    
    private $name;
    
    private $lan;
    
    private $description;
    
    private $ip;
    
    private $mac;
    
    private $mask;
    
    private $enable;

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
        foreach ($this->subnetList as $subnet) {
            unset ($subnet);
        }
        unset($this->subnetList);
    }

    public function getSubnetList() {
        return $this->subnetList;
    }

    public function setSubnetList($subnetList) {
        if (Lib_Validator::validateArray($subnetList, "Core_Model_Class_Subnet")) {
            $this->subnetList = $subnetList;
        }
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (Lib_Validator::validateString($name, 10)) {
            $this->name = $name;
        }
    }

    public function getLan() {
        return $this->lan;
    }

    public function setLan($lan) {
        if (Lib_Validator::validateBoolean($lan)) {
            $this->lan = $lan;
        }
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if (Lib_Validator::validateString($description, 200)) {
            $this->description = $description;
        }
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        if (Lib_Validator::validateString($ip, 40)) {
            $this->ip = $ip;
        }
    }

    public function getMac() {
        return $this->mac;
    }

    public function setMac($mac) {
        if (Lib_Validator::validateString($mac, 17)) {
            $this->mac = $mac;
        }
    }

    public function getMask() {
        return $this->mask;
    }

    public function setMask($mask) {
        if (Lib_Validator::validateString($mask, 40)) {
            $this->mask = $mask;
        }
    }

    public function getEnable() {
        return $this->enable;
    }

    public function setEnable($enable) {
        if (Lib_Validator::validateBoolean($enable)) {
            $this->enable = $enable;
        }
    }

}
?>
