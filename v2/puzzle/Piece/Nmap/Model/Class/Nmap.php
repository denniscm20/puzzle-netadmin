<?php

/*
 * Nmap/Model/Class/Nmap.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the nmap command interface
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Nmap
 * @subpackage Model/Class
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Nmap_Model_Class_Nmap extends Base_Command {

    private $scanDate = "";
    private $account = null;
    private $address = "";

    public function __construct() {
        parent::__construct();
        $this->command = "nmap";
        // The paramters of the command will be -sP and the IP Addresses to be
        // scanned
        $this->parameters = "-sP %s";
        $this->address = "";
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function getScanDate() {
        return $this->scanDate;
    }

    public function setScanDate($scanDate) {
        $this->scanDate = $scanDate;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setAccount($account) {
        $this->account = $account;
    }

    public function setOptions($options)
    {
        $this->address = $options;
        $this->parameters = sprintf($this->parameters, $this->address);
    }

    public function getOptions()
    {
        return $this->address;
    }

    /**
     * Parses the output of the executed command
     * @access protected
     * @param String $result Output to be parsed.
     * @return Array Parsed output
     */
    protected function parseOutput($result)
    {
        $lines = split("\n", $result);
        array_pop($lines);
        array_shift($lines);
        $count = count($lines);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $start = strlen('Host ');
                $end = strpos($lines[$i], ' is up') - $start + 1;
                $lines[$i] = trim(substr($lines[$i], $start, $end));
            }
            return $lines;
        }
    }

    public function scan() {
        return $this->executeCommand();
    }
}
?>
