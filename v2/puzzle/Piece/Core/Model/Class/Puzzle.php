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
     * Primary DNS Server
     * @var String
     * @access private
     */
    private $dns1;

    /**
     * Secondary DNS Server
     * @var String
     * @access private
     */
    private $dns2;

    /**
     * A flag that indicates if the forward has been activated.
     * @var Boolean
     * @access private
     */
    private $forward;

    /**
     * Class constructor
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->hostname = "";
        $this->dns1 = "";
        $this->dns2 = "";
        $this->forward = false;
    }

    /**
     * Class destructor
     * @access public
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    public function getHostname() {
        return $this->hostname;
    }

    public function setHostname($hostname) {
        if (Lib_Validator::validateString($hostname, 50)) {
            $this->hostname = $hostname;
        }
    }

    public function getDns1() {
        return $this->dns1;
    }

    public function setDns1($dns1) {
        if (Lib_Validator::validateString($dns1, 40)) {
            $this->dns1 = $dns1;
        }
    }

    public function getDns2() {
        return $this->dns2;
    }

    public function setDns2($dns2) {
        if (Lib_Validator::validateString($dns2, 40)) {
            $this->dns2 = $dns2;
        }
    }

    public function getForward() {
        return $this->forward;
    }

    public function setForward($forward) {
        if (Lib_Validator::validateBoolean($forward)) {
            $this->forward = $forward;
        }
    }
}
?>