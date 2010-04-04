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

require_once PATH_BASE.'Command.php';

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

class Core_Model_Class_Puzzle extends Base_Command
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
    private $dns;

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
        $this->loadHostname();
        $this->loadDns();
        $this->loadForward();
        $this->loadMemory();
        $this->loadDisk();
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

    public function getDns() {
        return $this->dns;
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

    public function setInterfaceList($interfaceList)
    {
        $this->interfaceList = $interfaceList;
    }

    /**
     * Enable the forward falg in the /proc/sys/net/ipv4/ip_forward file
     * @access public
     */
    public function enableForward()
    {
        $this->command = "echo 1 | sudo /usr/bin/tee /proc/sys/net/ipv4/ip_forward";
        $this->parameters = "";
        $this->executeCommand();
    }

    /**
     * Disable the forward falg in the /proc/sys/net/ipv4/ip_forward file
     * @access public
     */
    public function disableForward()
    {
        $this->command = "echo 1 | sudo /usr/bin/tee /proc/sys/net/ipv4/ip_forward";
        $this->parameters = "";
        $this->executeCommand();
    }

    /**
     * Scan the current configured network interfaces
     * @access public
     */
    public function scanInterfaces()
    {
        $this->command = "/sbin/ifconfig";
        $this->parameters = "-a";
        $lines = $this->executeCommand();
        $className = Lib_Helper::getClass("Core", "Interface");

        $counter = 0;
        $interface = null;
        foreach ($lines as $line) {
            if ($counter == 0) {
                $interface = new $className();
            }
            switch ( $counter ) {
                case 0:
                    $interface->Name = substr($line, 0, strpos($line,' '));
                    $interface->Mac = $this->loadMacInformation($line);
                    break;
                case 1:
                    $interface->Mask4 = $this->loadMask4($line);
                    if ($interface->Mask4 != "") {
                        $interface->Ip4 = $this->loadIp4($line); 
                    }
                    break;
                case 2:
                    $interface->Ip6 = $this->loadIp6($line);
                    if ($interface->Mask6 != "") {
                        $interface->Mask6 = $this->loadMask6($line);
                    }
                    break;
                default: 
                    if (trim($line) == "") {
                        $counter = 0;
                        $this->interfaceList[] = $interface;
                    }
                    continue;
            }
            ++$counter;
        }
    }

    /**
     * Parses the provided $line parameter in order to retrieve the MAC Address
     * @param String $line ifconfig line
     * @return String Mac Address
     */
    private function loadMacInformation( $line )
    {
        $pos = strpos($line,'HWaddr ');
        if ($pos !== false) {
            return substr($line, $pos + strlen('HWaddr '));
        }
        return "";
    }

    /**
     * Parses the provided $line parameter in order to retrieve the Network mask
     * @param String $line ifconfig line
     * @return String IPv4 Mask
     */
    private function loadMask4 ( $line )
    {
        $pos = strpos($line, '  Mask:');
        if ($pos !== false) {
            $offset = strlen('  Mask:');
            return substr($line, $pos + $offset);
        }
        return "";
    }

    /**
     * Parses the provided $line parameter in order to retrieve the Network mask
     * @param String $line ifconfig line
     * @return String IPv6 Mask
     */
    private function loadMask6 ( $line )
    {
        $pos =  strpos($line,'/');
        if ($pos !== false) {
            $offset = strlen('/');
            $limit = strpos($line, ' Scope:');
            $mask = substr($line, $pos + $offset, $limit - $pos - $offset);
            /**
             * @todo Implement method to transform an IPv6 short mask
             * to its long mask format.
             */
            return $mask;
        }
        return "";
    }

    /**
     * Parses the provided $line parameter in order to retrieve the IPv4 Address
     * @param String $line ifconfig line
     * @return String IPv4 Address
     */
    private function loadIp4 ( $line )
    {
        $limit = strpos ($line,'  Bcast:');
        if ($limit !== false) {
            $limit = strpos($line, '  Mask:');
        }
        $pos =  strpos($line,'inet addr:');
        $offset = strlen('inet addr:');
        return substr($line, $pos + $offset, $limit - $pos - $offset);
    }

    /**
     * Parses the provided $line parameter in order to retrieve the IPv6 Address
     * @param String $line ifconfig line
     * @return String IPv6 Address
     */
    private function loadIp6 ( $line )
    {
        $pos =  strpos($line,'inet6 addr: ');
        if ($pos !== false) {
            $offset = strlen('inet6 addr: ');
            $limit = strpos($line, "/");
            return substr($line, $pos + $offset, $limit - $pos - $offset);
        }
        return "";
    }

    /**
     * Loads the Server hostname
     * @access private
     */
    private function loadHostname()
    {
        $this->command = "hostname";
        $this->parameters = "";
        $output = $this->executeCommand();
        $this->hostname = $output[0];
    }

    /**
     * Loads the Server DNS adresses
     * @access private
     */
    private function loadDns()
    {
        $lines = file("/etc/resolv.conf");
        $this->dns = array();
        foreach ($lines as $line) {
            if (strpos($line, "nameserver ") === 0) {
                $this->dns[] = substr(trim($line), strlen("nameserver "));
            }
        }
    }

    /**
     * Loads the Server Forward Flag
     * @access private
     */
    private function loadForward()
    {
        $lines = file("/proc/sys/net/ipv4/ip_forward");
        $this->forward = ($lines[0] == 1);
    }

    /**
     * Loads the Server Memory Ussage
     * @access private
     */
    private function loadMemory()
    {
        $this->command = "free";
        $this->parameters = "-m";
        $lines = $this->executeCommand();
        $result = array();
        foreach ($lines as $line) {
            if (strpos($line,"Mem:") !== false || strpos($line,"Swap:") !== false) {
                $line = Lib_Helper::clearMiddleSpaces($line);
                $line = split(" ", $line);
                $result[] = array($line[1], $line[2]);
            }
        }
        //array((ram_total", "ram_used"), (swap_total", "swap_used));
        $this->memory = $result;
    }

    /**
     * Loads the Server Disk Ussage
     * @access private
     */
    private function loadDisk()
    {
        $this->command = "df";
        $this->parameters = "-m";
        $lines = $this->executeCommand();
        $result = array();
        foreach ($lines as $line) {
            if (strpos($line,"/dev/") === 0) {
                $line = Lib_Helper::clearMiddleSpaces($line);
                $line = split(" ", $line);
                $result[] = array($line[5], $line[1], $line[2]);
            }
        }
        // array(array("label", "disk_total", "disk_used"));
        $this->disk = $result;
    }    
}
?>