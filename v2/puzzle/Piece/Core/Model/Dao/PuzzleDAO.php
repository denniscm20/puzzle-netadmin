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
        $puzzle = $this->loadObjectReferences($puzzle, null);
        return $puzzle;
    }

    /**
     * Enable the forward falg in the /proc/sys/net/ipv4/ip_forward file
     * @access public
     */
    public function enableForward()
    {
        $command = "echo 1 | sudo /usr/bin/tee /proc/sys/net/ipv4/ip_forward";
        /** @todo Execute Command */
    }

    /**
     * Disable the forward falg in the /proc/sys/net/ipv4/ip_forward file
     * @access public
     */
    public function disableForward()
    {
        $command = "echo 1 | sudo /usr/bin/tee /proc/sys/net/ipv4/ip_forward";
        /** @todo Execute Command */
    }

    /**
     * Loads the Server hostname
     * @access private
     */
    private function loadHostname()
    {
        $command = "hostname";
        /** @todo Execute Command */
    }

    /**
     * Loads the Server DNS adresses
     * @access private
     */
    private function loadDns()
    {
        $lines = file("/etc/resolv.conf");
        $dns = array();
        foreach ($lines as $line) {
            if (strpos($line, "nameserver ") === 0) {
                $dns[] = substr(trim($line), strlen("nameserver "));
            }
        }
        return $dns;
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
        $command = "free -m";
        /** @todo Execute Command or Read /proc/meminfo file */
        //$lines = $command->execute();
        $result = array();
        foreach ($lines as $line) {
            if (strpos($line,"Mem:") !== false || strpos($line,"Swap:") !== false) {
                $line = Lib_Helper::clearMiddleSpaces($line);
                $line = split(" ", $line);
                $result[] = array($line[1], $line[2]);
            }
        }
        //array((ram_total", "ram_used"), (swap_total", "swap_used));
        return $result;
    }

    /**
     * Loads the Server Disk Ussage
     * @access private
     */
    private function loadDisk()
    {
        $command = "df -m";
        /** @todo Execute Command */
        $lines = $command->execute();
        $result = array();
        foreach ($lines as $line) {
            if (strpos($line,"/dev/") === 0) {
                $line = Lib_Helper::clearMiddleSpaces($line);
                $line = split(" ", $line);
                $result[] = array($line[5], $line[1], $line[2]);
            }
        }
        // array(array("label", "disk_total", "disk_used"));
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