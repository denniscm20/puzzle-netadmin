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
    private $user;

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
        Lib_Helper::getClass("Core", "AccessLog");
        Lib_Helper::getClass("Core", "Account");
        
        $this->user = new Core_Model_Class_Account();
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
        unset($this->storedUser);
    }

    protected function call($event)
    {
        switch ($event) {
            case "load":
            case "login":
            case "logout":
            case "token":
            case "password":
                break;
            default: $event = DEFAULT_EVENT;
        }
        return $event;
    }

    /**
     * Adds elements to the controller that will be required by the view
     *
     * @access protected
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     */
    protected function loadElements()
    {
        return;
    }

    /**
     * Logs the user into the system
     * @access protected
     */
    protected function login()
    {
        $user = $this->retrieveUser();
        if ($user !== null) {
            $username = $user->Username;
            if ($user->validatePassword($this->user->Password) === true) {
                $this->grantAccess($username);
            } else {
                $this->denyAcccess($username, Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE);
            }
        } else {
            $this->denyAcccess("", Core_Model_Class_AccessLog::ACCESS_TYPE_NOT_EXIST);
        }
    }

    /**
     * This function is called when the user has received a token to his email
     * in order to change his password
     * @access protected
     */
    protected function token()
    {
        $user = $this->retrieveUser();
        if ($user !== null) {
            $username = $user->Username;
            if ($user->validateToken($this->user->Token) === true) {
                $this->clearToken();
                $this->grantAccess($username);
            } else {
                $this->denyAcccess($username, Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE);
            }
        } else {
            $this->denyAcccess($username, Core_Model_Class_AccessLog::ACCESS_TYPE_NOT_EXIST);
        }
    }


    /**
     * Log out the user from the system
     * @access protected
     */
    protected function logout()
    {
    	if (isset($_SESSION["User"])) {
            $username = $_SESSION["User"]["Account"];
            session_unset();
            $sessionDestroyed = session_destroy();
            $messageHandler = Lib_MessagesHandler::getInstance();
            if ($sessionDestroyed !== false) {
                $messageHandler->addInformation(LOGIN_LOGOUT_INFO);
            } else {
                $messageHandler->addError(LOGIN_LOGOUT_ERROR);
            }
            $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_LOG_OUT);
        } else {
            Lib_Helper::redirect("Core", "Login");
        }
    }

    /**
     * This function is called when the user does not remember his/her password
     * so he/she asks the system for sending a new one to them.
     * @access protected
     */
    protected function password()
    {
        $user = $this->retrieveUser();
        if ($user !== null) {
            $token = $user->generateToken();
            $mail = new Lib_Mail(array($user->Email), LOGIN_MAIL_SUBJECT,
                    sprintf(LOGIN_MAIL_BODY, $token), EMAIL_ACCOUNT, 1);
            $messageHandler = Lib_MessagesHandler::getInstance();
            if ($mail->send() == 1) {
                $messageHandler->addInformation(LOGIN_PASSWORD_INFO);
            } else {
                $messageHandler->addEror(LOGIN_PASSWORD_ERROR);
            }
        }
    }

    /**
     * Loads the page information
     * @access protected
     */
    protected function load()
    {
        return;
    }

    protected function filterInput()
    {
        if (filter_input(INPUT_POST, "submit") !== null) {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            $token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING);
            $this->user->Username = $username != null?$username:"";
            $this->user->Password = $password != null?$password:"";
            $this->user->Token = $token != null?$token:"";
        }
    }

    /**
     * Retrieves an account object from the database
     * @access private
     * @return Core_Model_Class_Account NULL if there is no match
     */
    private function retrieveUser()
    {
        Lib_Helper::getDao("Core", "Account");
        $user = new Core_Model_Class_Account();
        $user->Username = $this->user->Username;
        $user->Enabled = true;
        $accountDAO = new Core_Model_Dao_AccountDAO($user);
        return $accountDAO->selectByUsernameAndEnabled();
    }

    private function clearToken()
    {
        Lib_Helper::getDao("Core", "Account");
        $accountDAO = new Core_Model_Dao_AccountDAO($user);
        $accountDAO->clearToken();
    }

    /**
     * Grant access to the user with the provided account values.
     * @access private
     */
    private function grantAccess($username)
    {
        $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_SUCCESS);
        $_SESSION["User"]["Id"] = $this->user->Id;
        $_SESSION["User"]["Account"] = $this->user->Username;
        $_SESSION["User"]["Role"] = $this->user->Role->Id;
        session_write_close();
        Lib_Helper::redirect(DEFAULT_PIECE, DEFAULT_PAGE);
    }

    /**
     * Deny access to the user with the provided account values.
     * @access private
     */
    private function denyAcccess($username, $cause)
    {
        $this->log($username, $cause);
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(LOGIN_LOGIN_ERROR);
    }
}

?>
