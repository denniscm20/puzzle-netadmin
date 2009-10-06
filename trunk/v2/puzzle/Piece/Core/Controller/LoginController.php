<?php
/*
 * Core/Controller/LoginController.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the methods of the login controller class.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Controller
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_Controller_LoginController extends Base_Controller
{
    
    // --- ASSOCIATIONS ---

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
     * Indicates which is the action that will be executed.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @param  String event
     */
    public function execute( $event )
    {
        switch ($event) {
            case "load":
            case "login":
            case "logout":
                break;
            default: $event = "load";
        }
        $this->{$event}();
        $this->loadElements();
    }

    protected function login()
    {
        if ($this->validateInput() === true) {
            $user = $this->retrieveUser();
            $this->verifyChangePassword($user->ChangePasword);
            $value = $this->verifyPassword($user->Password, $user->Salt);
            if ($value === true) {
                $this->grantAccess($user);
                $this->log($message);
            }
        }
        $this->denyAcccess();
        $this->log($message);
    }

    protected function logout()
    {
    	if (isset($_SESSION["User"])) {
        	session_unset();
            $messageHandler = Lib_MessagesHandler::getInstance();
            if (session_destroy() !== false) {
                $messageHandler->addInformation(LOGIN_LOGOUT_INFO);
            } else {
                $messageHandler->addError(LOGIN_LOGOUT_ERROR);
            }
            $this->log($message);
        }
    }

    protected function load()
    {
        return;
    }

    private function validateInput()
    {
        $result = false;
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $cleanUsername = Lib_Cleaner::clearString($_POST["username"]);
        $cleanPassword = Lib_Cleaner::clearString($_POST["password"]);
        if ($username == $cleanUsername && $password == $cleanPassword) {
            $result = (Lib_Validator::validateString($cleanUsername, 20)) &&
                      (Lib_Validator::validateString($cleanPassword, 210));
        }
        return $result;
    }

    private function retrieveUser()
    {
        Lib_Helper::getDao("Core", "AccountDAO");
        $user = new Core_Model_Class_Account();
        $user->Username = trim($_POST["username"]);
        $user->Enabled = true;
        $accountDAO = new Core_Model_Dao_AccountDAO($user);
        $user = $accountDAO->selectByUsernameAndEnabled();
        return $user;
    }

    private function verifyChangePassword($changePasword)
    {
        if ($changePasword === true) {
            Lib_Helper::redirect("Core", "Account");
        }
    }

    private function verifyPassword($password, $salt)
    {
        $currentpassword = $salt.trim($_POST["password"]);
        $cypher = hash("sha512", $currentpassword);
        return ($password == $cypher);
    }

    private function grantAccess($user)
    {
        $_SESSION["User"] = serialize($user);
        session_write_close();
        Lib_Helper::redirect(DEFAULT_PIECE, DEFAULT_LOGIN_PAGE);
    }

    private function denyAcccess()
    {
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(LOGIN_LOGIN_ERROR);
    }

    private function log($type, $message)
    {
        
    }
    
}

?>
