<?php
/*
 * Core/Model/Class/Service.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements a network service.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Class
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Service extends Base_Class
{
    private $name;

    private $portList;

    private $protocolList;

    public function __construct()
    {
        parent::__construct();
        $this->name = "";
        $this->portList = array();
        $this->protocolList = array();
    }

    public function __destruct()
    {
        parent::__destruct();

        foreach ($this->portList as $port) {
            unset($port);
        }
        unset($this->portList);

        foreach ($this->protocolList as $protocol) {
            unset ($protocol);
        }
        unset ($this->protocolList);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (Lib_Validator::validateString($name, 10)) {
            $this->name = $name;
        }
    }

    public function getPortList() {
        return $this->portList;
    }

    public function setPortList($portList) {
        if (Lib_Validator::validateArray($portList, "Core_Model_Class_Port")) {
            $this->portList = $portList;
        }
    }

    public function getProtocolList() {
        return $this->protocolList;
    }

    public function setProtocolList($protocolList) {
        if (Lib_Validator::validateArray($protocolList, "Core_Model_Class_Protocol")) {
            $this->protocolList = $protocolList;
        }
    }

}
?>
