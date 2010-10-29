<?php
/*
 * Core/Model/Dao/InterfaceDAO.php - Copyright 2010 Dennis Cohn Muroy
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
require_once PATH_LIB.'Command.php';

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

class Core_Model_Dao_InterfaceDAO extends Base_DAO
{

    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function save ()
    {

    }

    public function load ()
    {

    }

    public function selectList()
    {
        $this->query = "SELECT id, name FROM Interface WHERE enable = ?";
        $this->parameters = array(true);
        return parent::listObjects(0, MAX_LIST_LIMIT);
    }

    /**
     * Scan the current configured network interfaces
     * @access public
     */
    public function scanInterfaces()
    {
        $command = "/sbin/ifconfig";
        $command = new Lib_Command($command, "-a");
        $lines = $command->execute();
        
        $counter = 0;
        $interface = null;
        $interfaceList = array();
        foreach ($lines as $line) {
            switch ( $counter ) {
                case 0:
                    $interface = new Core_Model_Class_Interface();
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
                        $interfaceList[] = $interface;
                    }
                    continue;
            }
            ++$counter;
        }
        return $interfaceList;
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

    protected function loadObjectReferences($object, $result)
    {
        return $object;
    }
}
?>