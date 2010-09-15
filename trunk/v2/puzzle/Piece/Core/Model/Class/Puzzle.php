<?php
/*
 * Core/Model/Class/Puzzle.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the core of the puzzle application.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Puzzle extends Base_Class
{
    /**
     * The name of the host where the Puzzle Application is installed
     * @var String
     * @access private
     */
    private $hostname;

    /**
     * Server DNS List
     * @var Array
     * @access private
     */
    private $dnsList;

    /**
     * A flag that indicates if the forward has been activated.
     * @var Boolean
     * @access private
     */
    private $forward;

    /**
     * Array that stores the ammount of memory that has been allocated
     * @var Array
     * @access private
     */
    private $memory;

    /**
     * Array that stores the current use of each partition in the hard disk
     * @var Array
     * @access private
     */
    private $disk;

    /**
     * List of interfaces connected to the server where the application is
     * installed
     * @var Array
     * @access private
     */
    private $interfaceList;

    /**
     * Class constructor
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->hostname = "";
        $this->dnsList = array();
        $this->forward = 1;
        $this->memory = array();
        $this->disk = array();
        $this->interfaceList = array();
    }

    /**
     * Class destructor
     * @access public
     */
    public function __destruct()
    {
        parent::__destruct();
        foreach ($this->interfaceList as $interface) {
            unset($interface);
        }
        unset($this->interfaceList);
    }

    public function getHostname() {
        return $this->hostname;
    }

    public function getDnsList() {
        return $this->dnsList;
    }

    public function getForward() {
        return $this->forward;
    }

    public function getMemory() {
        return $this->memory;
    }

    public function getDisk() {
        return $this->disk;
    }

    public function getInterfaceList()
    {
        return $this->interfaceList;
    }

    public function setHostname($hostname) {
        $this->hostname = $hostname;
    }

    public function setDnsList($dnsList) {
        if (Lib_Validator::validateArray($dnsList)) {
            $this->dnsList = $dns;
        }
    }

    public function setForward($forward) {
        $this->forward = $forward;
    }

    public function setMemory($memory) {
        $this->memory = $memory;
    }

    public function setDisk($disk) {
        $this->disk = $disk;
    }

    public function setInterfaceList($interfaceList)
    {
        if (Lib_Validator::validateArray($interfaceList, 'Core_Model_Class_Interface')) {
            $this->interfaceList = $interfaceList;
        }
    }      
}
?>