<?php
/*
 * Core/Model/Class/AccessLog.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements an access log entry in the system.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_AccessLog extends Base_Class {

    const ACCESS_TYPE_SUCCESS = 1;
    const ACCESS_TYPE_LOG_OUT = 2;
    const ACCESS_TYPE_FAILURE = 3;
    const ACCESS_TYPE_NOT_EXIST = 4;

    private $username;
    private $ip;
    private $datetime;
    private $accessType;
    private $description;

    public function  __construct() {
        parent::__construct();
        $this->username = "";
        $this->ip = "";
        $this->datetime = date();
        $this->accessType = 0;
        $this->description = "";
    }

    public function  __destruct() {
        parent::__destruct();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function getAccessType()
    {
        return $this->accessType;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setUsername($username)
    {
        if (Lib_Validator::validateString($username, 20)) {
            $this->username = $username;
        }
    }

    public function setIp($ip)
    {
        if (Lib_Validator::validateString($ip, 40)) {
            $this->ip = $ip;
        }
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function setAccessType( $accessType )
    {
        if (Lib_Validator::validateInteger($accessType)) {
            $this->accessType = $accessType;
        }
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    
}
?>
