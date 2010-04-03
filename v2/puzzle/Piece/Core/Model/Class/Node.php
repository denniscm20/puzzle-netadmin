<?php

/*
 * Core/Model/Class/Node.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements a node in the system.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Class
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Node extends Base_Class
{

    private $serviceList = array();
    
    private $name;
    
    private $ip;
    
    private $mask;

    public function __construct() {
        parent::__construct();
        $this->name = "";
        $this->ip = "";
        $this->mask = "";
        $this->serviceList = array();
    }

    public function __destruct() {
        parent::__destruct();
        foreach ($this->serviceList as $service) {
            unset($service);
        }
        unset ($this->serviceList);
    }

    public function getServiceList() {
        return $this->serviceList;
    }

    public function setServiceList($serviceList) {
        if (Lib_Validator::validateArray($serviceList, "Core_Model_Class_Service")) {
            $this->serviceList = $serviceList;
        }
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (Lib_Validator::validateString($name, 30)) {
            $this->name = $name;
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

    public function getMask() {
        return $this->mask;
    }

    public function setMask($mask) {
        if (Lib_Validator::validateString($mask, 40)) {
            $this->mask = $mask;
        }
    }

}
?>
