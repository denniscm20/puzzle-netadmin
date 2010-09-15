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

    /**
     * The name of the user who triggered the event
     * @access private
     * @var String
     */
    private $username;

    /**
     * The ip from where the event was triggered
     * @access private
     * @var String
     */
    private $ip;

    /**
     * The date and time of the event
     * @access private
     * @var String
     */
    private $timestamp;

    /**
     * The type of access that was performed.
     * @access private
     * @var Core_Model_Class_AccessType
     */
    private $accessType;

    /**
     * Class contructor
     * @access public
     */
    public function  __construct() {
        parent::__construct();
        $this->username = "";
        $this->ip = "";
        $this->timestamp = time();
        $className = Lib_Helper::getClass("Core", "AccessType");
        $this->accessType = new $className();
    }

    /**
     * Class destructor
     * @access public
     */
    public function  __destruct() {
        parent::__destruct();
        unset($this->accessType);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getAccessType()
    {
        return $this->accessType;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setAccessType( $accessType )
    {
        $this->accessType = $accessType;
    }

}
?>