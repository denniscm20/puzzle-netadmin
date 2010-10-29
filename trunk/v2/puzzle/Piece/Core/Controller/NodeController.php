<?php
/*
 * Core/Controller/NodeController.php - Copyright 2010 Dennis Cohn Muroy
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
 * Class that implements the methods of the node controller class.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Core
 * @subpackage Controller
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class NodeController extends Base_Controller
{
    private $node = null;
    private $nodeDAO = null;

    private $serviceList = null;
    private $serviceDAO = null;

    private $subnet = null;

    protected function __construct()
    {
        parent::__construct();
        
        Lib_Helper::getClass("Core", "Node");
        Lib_Helper::getClass("Core", "Service");
        Lib_Helper::getClass("Core", "Subnet");
        Lib_Helper::getDAO("Core", "Node");
        Lib_Helper::getDAO("Core", "Service");
        Lib_Helper::getDAO("Core", "Subnet");

        $this->node = new Core_Model_Class_Node();
        $this->serviceList = array();
        $this->subnet = new Core_Model_Class_Subnet();
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
        unset($this->node);
        unset($this->nodeDAO);
        unset($this->serviceDAO);
        unset($this->subnet);
        foreach ($this->serviceList as $service){
            unset($service);
        }
        unset($this->serviceList);
    }

    protected function call($event)
    {
        switch($event) {
            case "load":
            case "save":
            case "add":
                $event = "editService";
                break;
            case "add":
                $event = "addService";
                break;
            case "remove":
                $event = "removeService";
                break;
            default: $event = DEFAULT_EVENT;
        }
        return $event;
    }

    protected function filterInput()
    {
        $this->node->Id = $this->identifier;
        $this->subnet->Id = filter_input(INPUT_POST, "subnet", FILTER_SANITIZE_NUMBER_INT);
        if (filter_input(INPUT_POST, "submit-data") !== null) {
            $this->node->Name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $this->node->Description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
            $this->node->Ipv4 = filter_input(INPUT_POST, "ipv4", FILTER_FLAG_IPV4);
            $this->node->Ipv6 = filter_input(INPUT_POST, "ipv6", FILTER_FLAG_IPV6);
        } elseif (filter_input(INPUT_POST, "submit-add") !== null) {
            $this->serviceList = array(filter_input(INPUT_POST, "service", FILTER_SANITIZE_NUMBER_INT));
        } elseif (filter_input(INPUT_POST, "submit-remove") !== null) {
            $this->serviceList = filter_input(INPUT_POST, "services", FILTER_SANITIZE_NUMBER_INT);
        }        
    }

    protected function loadElements() 
    {
        $this->serviceList = $this->serviceDAO->selectList();
        $subnetDAO = new Core_Model_Dao_SubnetDAO($this->subnet);
        $this->subnet = $subnetDAO->load();
        $this->add("node", $this->node);
        $this->add("serviceList", $this->serviceList);
        $this->add("subnet", $this->subnet);
    }

    protected function load()
    {
        $this->nodeDAO = new Core_Model_Dao_NodeDAO($this->node);
        $this->node = $this->nodeDAO->load();
    }

    protected function save()
    {
        $this->nodeDAO = new Core_Model_Dao_NodeDAO($this->node);
        try {
            $result = $this->nodeDAO->save($this->subnetId);
        } catch (PDOException $ex) {

        }
    }

    protected function addService()
    {
        try {
            if (count($this->serviceList) > 0) {
                $service = new Core_Model_Class_Service();
                $service->Id = $this->serviceList[0];
                $this->serviceDAO = new Core_Model_Dao_ServiceDAO($this->service);
                $this->serviceDAO->addService($this->node->Id);
            }
            $this->load();
        } catch (PDOException $ex) {

        }
    }

    protected function removeService()
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

    protected function editService()
    {
        
    }
}