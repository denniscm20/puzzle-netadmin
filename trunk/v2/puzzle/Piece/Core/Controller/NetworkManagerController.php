<?php
/*
 * Core/Controller/NetworkManagerController.php - Copyright 2010 Dennis Cohn Muroy
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

require_once PATH_BASE.'Controller.php';

/**
 * Class that implements the methods of the network manager controller class.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Controller
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class NetworkManagerController extends Base_Controller
{
    private $interfaceList = array();
    private $subnetList = array();
    private $subnet = null;
    private $interface = null;

    protected function __construct()
    {
        parent::__construct();

        Lib_Helper::getClass("Core", "Interface");
        Lib_Helper::getClass("Core", "Subnet");
        Lib_Helper::getDAO("Core", "Interface");
        Lib_Helper::getDAO("Core", "Subnet");

        $this->interface = new Core_Model_Class_Interface();
        $this->interfaceList = array();
        $this->subnetList = array();
        $this->subnet = null;
    }

    /**
     * Class destructor.
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return void
     */
    public function __destruct()
    {
        parent::__destruct();
        foreach($this->interfaceList as $interface)
            unset($interface);
        unset($this->interfaceList);
        foreach ($this->subnetList as $subnet)
            unset($subnet);
        unset($this->subnetList);
        unset($this->subnet);
        unset($this->interface);
    }

    protected function call($event)
    {
        switch($event) {
            case "load":
            case "search":
            case "next":
            case "prev":
                break;
            case "remove":
                $event = "removeSubnet";
                break;
            default: $event = DEFAULT_EVENT;
        }
        return $event;
    }

    protected function filterInput()
    {
        if (filter_input(INPUT_POST, "submit-search") !== null) {
            $this->subnet = new Core_Model_Class_Subnet();
            $this->subnet->Name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $ip = filter_input(INPUT_POST, "ip");
            if (Lib_Validator::validateIPv4($ip)) {
                $this->subnet->Ipv4 = $ip;
            } elseif (Lib_Validator::validateIPv6($ip)) {
                $this->subnet->Ipv6 = $ip;
            }
            $this->interface->Id = filter_input(INPUT_POST, "interface", FILTER_SANITIZE_NUMBER_INT);
        } elseif (filter_input(INPUT_POST, "submit-add") !== null) {
            $this->serviceList = array(filter_input(INPUT_POST, "service", FILTER_SANITIZE_NUMBER_INT));
        } elseif (filter_input(INPUT_POST, "submit-remove") !== null) {
            $this->serviceList = filter_input(INPUT_POST, "services", FILTER_SANITIZE_NUMBER_INT);
        }
    }

    protected function loadElements()
    {
        $this->add("interfaceList", $this->interfaceList);
        $this->add("subnet", $this->subnet);
        $this->add("subnetList", $this->subnetList);
    }

    protected function load()
    {
        $interfaceDAO = new Core_Model_Dao_InterfaceDAO($this->interface);
        $this->interfaceList = $interfaceDAO->selectList();
        if ($this->subnet !== null) {
            $subnetDAO = new Core_Model_Dao_SubnetDAO($this->subnet);
            $this->subnetList = $subnetDAO->selectListByInterface($this->interface->Id, $start);
        } else {
            $subnetDAO = new Core_Model_Dao_SubnetDAO("Core_Model_Class_Subnet");
            $subnetList = array();
            foreach ($this->interfaceList as $interface) {
                $subnetList = $subnetDAO->selectListByInterface($interface->Id, $start);
                $start = count($subnetList);
            }
        }
    }

    protected function search()
    {
        $this->nodeDAO = new Core_Model_Dao_NodeDAO($this->node);
        try {
            $result = $this->nodeDAO->save($this->subnetId);
        } catch (PDOException $ex) {

        }
    }

    protected function removeSubnet()
    {
        try {
            foreach ($this->serviceList as $service_id) {
                if (Lib_Validator::validateInteger($service_id)) {
                    $service = new Core_Model_Class_Service();
                    $service->Id = $service_id;
                    $this->serviceDAO = new Core_Model_Dao_ServiceDAO($this->service);
                    $this->serviceDAO->removeService($this->node->Id);
                }
            }
            $this->load();
        } catch (PDOException $ex) {

        }
    }
}