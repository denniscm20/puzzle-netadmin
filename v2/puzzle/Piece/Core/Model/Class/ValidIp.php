<?php
/*
 * Core/Model/Class/ValidIp.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements a valid IP that can access the system.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_ValidIp extends Base_Class {
    
    /**
     * The IP Address
     * @var String
     * @access private
     */
    private $ip;

    /**
     * If the IPAddress is a ipv4 address
     * @var Boolean
     * @access private
     */
    private $ipv4;

    public function  __construct()
    {
        parent::__construct();
        $this->ip = "";
        $this->ipv4 = true;
    }

    public function  __destruct()
    {
        parent::__destruct();
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getIpv4()
    {
        return $this->ipv4;
    }

    public function setIp($ip)
    {
        if (Lib_Validator::validateIp($ip) === true)
        {
            $this->ip = $ip;
            $this->ipv4 = Lib_Validator::validateIPv4($ip);
        }
    }

}
?>
