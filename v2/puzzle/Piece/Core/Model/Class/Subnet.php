<?php
/*
 * Core/Model/Class/Subnet.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements a subnet in the system.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Class
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Subnet extends Base_Class
{

    private $nodeList = array();

    private $name;

    private $description;

    private $ip;

    private $mask;

    private $shortMask;

    public function __construct() {
        parent::__construct();
        $this->name = "";
        $this->description = "";
        $this->ip = "";
        $this->mask = "0.0.0.0";
        $this->shortMask = 0;
    }

    public function __destruct() {
        parent::__destruct();
        foreach ($this->nodeList as $node) {
            unset ($node);
        }
        unset ($this->nodeList);
    }

    public function getNodeList() {
        return $this->nodeList;
    }

    public function setNodeList($nodeList) {
        if (Lib_Validator::validateArray($nodeList, "Core_Model_Class_Node")) {
            $this->nodeList = $nodeList;
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

    public function getMask() {
        return $this->mask;
    }

    public function setMask($mask) {
        if (Lib_Validator::validateString($mask, 40)) {
            $this->mask = $mask;
        }
    }

    public function getShortMask() {
        return $this->shortMask;
    }

    public function setShortMask($shortMask) {
        if (Lib_Validator::validateInteger($shortMask)) {
            $this->shortMask = $shortMask;
        }
    }

}
?>
