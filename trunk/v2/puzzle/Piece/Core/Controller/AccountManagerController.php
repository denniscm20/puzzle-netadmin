<?php
/*
 * Core/Controller/AccountController.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the methods of the account manager controller class.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Controller
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Controller_AccountManagerController extends Base_Controller
{

    private $user;

    private $accountList;

    // --- ATTRIBUTES ---

    /**
     * Class constructor
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return void
     */
    protected function __construct()
    {
        parent::__construct();
        Lib_Helper::getClass("Core", "Account");
        $this->user = new Core_Model_Class_Account();
        $this->accountList = array();
    }

    /**
     * Class destructor.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return void
     */
    public function __destruct()
    {
        parent::__destruct();
        unset($this->user);
        foreach ($this->accountList as $account) {
            unset ($account);
        }
        unset($this->accountList);
    }

    /**
     * Adds elements to the controller that will be required by the view
     *
     * @access protected
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     */
    protected function loadElements()
    {

    }

    /**
     * Returns the name of the method that will be executed
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy
     * @param  String event
     * @return Method name to execute
     */
    public function call( $event )
    {
        switch ($event) {
            case "load":
            case "search":
            case "delete":
                break;
            default: $event = DEFAULT_EVENT;
        }
        return $event;
    }

    /**
     * Loads the page information
     * @access protected
     */
    protected function load()
    {
        return;
    }

    /**
     * Searchs the system for an user account
     * @access protected
     */
    protected function search()
    {
        
        $this->load();
    }

    /**
     * Deletes an user account
     * @access protected
     */
    protected function delete()
    {
        $className = Lib_Helper::getDao("Core", "Account");
        $accountDAO = $className($this->user);
        $message = Lib_MessagesHandler::getInstance();
        if ($accountDAO->delete()) {
            $message->addInformation(ACCOUNT_DELETE_INFO);
        } else {
            $message->addError(ACCOUNT_DELETE_ERROR);
        }

        $this->load();
    }

    protected function validateInput()
    {
        $id = isset($_GET["id"])?$_GET["id"]:0;
        $username = isset($_POST["username"])?$_POST["username"]:"";
        $status = isset($_POST["status"])?$_POST["status"]:0;
        $role = isset($_POST["role"])?$_POST["role"]:true;

        $username = Lib_Cleaner::clearString($username);

        if (Lib_Validator::validateInteger($id)) {
            $this->user->Id = $id;
        }

        if (Lib_Validator::validateString($username, 20)) {
            $this->user->Username = $username;
            if (Lib_Validator::validateInteger($role)) {
                $this->user->Role->Id = $role;
                if (Lib_Validator::validateBoolean($status)) {
                    $this->user->Enabled = $status;
                    return true;
                }
            }
        }
        return false;
    }
}

?>
