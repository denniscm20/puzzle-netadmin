<?php
/*
 * Core/Model/Dao/PuzzleDAO.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the core of the puzzle application.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model/Dao
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Dao_PuzzleDAO extends Base_DAO
{

    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function load ()
    {
        $puzzle = new Core_Model_Class_Puzzle();
        $puzzle->Hostname = $this->loadHostname();
        $puzzle->DnsList = $this->loadDns();
        $puzzle->Forward = $this->loadForward();
        $puzzle->Disk = $this->loadDisk();
        $puzzle->Memory = $this->loadMemory();
        $puzzle->Load = $this->loadLoad();
        $puzzle = $this->loadObjectReferences($puzzle, null);
        return $puzzle;
    }

    /**
     * Enable the forward falg in the /proc/sys/net/ipv4/ip_forward file
     * @access public
     */
    public function enableForward()
    {
        $command = sprintf(SUDO_COMMAND, "Core forward 1");
        exec($command);
    }

    /**
     * Disable the forward falg in the /proc/sys/net/ipv4/ip_forward file
     * @access public
     */
    public function disableForward()
    {
        $command = sprintf(SUDO_COMMAND, "Core forward 0");
        exec($command);
    }

    /**
     * Loads the Server hostname
     * @access private
     */
    private function loadHostname()
    {
        $command = sprintf(SUDO_COMMAND, "Core hostname");
        return exec($command);
    }

    /**
     * Loads the Server DNS adresses
     * @access private
     */
    private function loadDns()
    {
        $lines = file("/etc/resolv.conf");
        $dnsList = array();
        foreach ($lines as $line) {
            if (strpos($line, "nameserver ") === 0) {
                $dnsList[] = substr(trim($line), strlen("nameserver "));
            }
        }
        return $dnsList;
    }

    /**
     * Loads the Server Forward Flag
     * @access private
     */
    private function loadForward()
    {
        $lines = file("/proc/sys/net/ipv4/ip_forward");
        return ($lines[0] == 1);
    }

    /**
     * Loads the Server Memory Ussage
     * @access private
     */
    private function loadMemory()
    {
        $lines = file("/proc/meminfo");
        $result = array();
        if (count($lines) > 0) {
            $total = trim(substr($lines[0], strlen("MemTotal:")));
            $free = trim(substr($lines[0], strlen("MemFree:")));
            $result = array($total, $free);
        }
        return $result;
    }

    /**
     * Loads the Server Load Average
     * @access private
     */
    private function loadLoad()
    {
        $lines = file("/proc/loadavg");
        $result = array();
        if (count($lines) > 0) {
            $array = split(" ", $lines[0]);
            $result = array($array[0], $array[1], $array[2]);
        }
        return $result;
    }

    /**
     * Loads the Server Disk Ussage
     * @access private
     */
    private function loadDisk()
    {
        $command = sprintf(COMMAND, "Core disk");
        exec($command, $output);
        $result = array();
        foreach ($output as $line) {
            if (strpos($line,"/dev/") === 0) {
                $line = Lib_Helper::clearMiddleSpaces($line);
                $line = split(" ", $line);
                $result[] = array($line[5] => array($line[1], $line[2]));
            }
        }
        return $result;
    }
    
    protected function loadObjectReferences($object, $result)
    {
        $interface = new Core_Model_Class_Interface();
        $interfaceDAO = new Core_Model_Dao_Interface($interface);
        $object->InterfaceList = $interfaceDAO->listObjects();
        return $object;
    }
}
?>