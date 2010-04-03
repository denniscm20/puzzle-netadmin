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
        
    }

    /**
     * Logs the user into the system
     * @access protected
     */
    protected function login()
    {
        $user = $this->retrieveUser();
        $username = $user->Username;
        if ($user === null) {
            // There were no matches in the database
            $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_NOT_EXIST);
        } else {
            if ($user->validatePassword($this->user->Password)) {
                $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_SUCCESS);
                $this->grantAccess();
            } else {
                $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE);
            }
        }
        $this->denyAcccess();
    }

    /**
     * Log out the user from the system
     * @access protected
     */
    protected function logout()
    {
    	if (isset($_SESSION["User"])) {
            $user = unserialize($_SESSION["User"]["Account"]);
            $username = $user->Username;
        	session_unset();
            $sessionDestroyed = session_destroy();
            $messageHandler = Lib_MessagesHandler::getInstance();
            if ($sessionDestroyed !== false) {
                $messageHandler->addInformation(LOGIN_LOGOUT_INFO);
            } else {
                $messageHandler->addError(LOGIN_LOGOUT_ERROR);
            }
            $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_LOG_OUT);
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
        $username = $user->Username;
        if ($user !== null) {
            if ($user->validateToken ($this->user->Token)) {
                $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_SUCCESS);
                $_SESSION["User"]["Account"] = serialize($this->user);
                session_write_close();
                Lib_Helper::redirect(DEFAULT_PIECE, "Account");
            } else {
                $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE);
            }
        } else {
            $this->log($username, Core_Model_Class_AccessLog::ACCESS_TYPE_NOT_EXIST);
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

    protected function validateInput()
    {
        $this->isValidIp();

        $username = isset($_POST["username"])?$_POST["username"]:"";
        $password = isset($_POST["password"])?$_POST["password"]:"";
        $token = isset($_POST["token"])?$_POST["token"]:"";
        
        $username = Lib_Cleaner::clearString($username);
        $password = Lib_Cleaner::clearString($password);
        $token = Lib_Cleaner::clearString($token);

        if (Lib_Validator::validateString($username, 20)) {
            $this->user->Username = $username;
            if (Lib_Validator::validateString($password, 210)) {
                $this->user->Password = $password;
                return true;
            }
            if (Lib_Validator::validateString($token, 210)) {
                $this->user->Token = $token;
                return true;
            }
        }
        return false;
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

    /**
     * Grant access to the user with the provided account values.
     * @access private
     */
    private function grantAccess()
    {
        $_SESSION["User"]["Account"] = serialize($this->user);
        session_write_close();
        Lib_Helper::redirect(DEFAULT_PIECE, DEFAULT_LOGIN_PAGE);
    }

    /**
     * Deny access to the user with the provided account values.
     * @access private
     */
    private function denyAcccess()
    {
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(LOGIN_LOGIN_ERROR);
    }

    /**
     * Validates that the user is accessing from an authorized IP address
     * @access private
     */
    private function isValidIp()
    {
        Lib_Helper::getClass("Core", "ValidIp");
        Lib_Helper::getDao("Core", "ValidIp");
        $validIp = new Core_Model_Class_ValidIp();
        $validIp->Ip = Lib_Helper::getRemoteIP();
        $validIpDAO = new Core_Model_Dao_ValidIpDAO($validIp);
        $validIp = $validIpDAO->selectByIp();
        if ($validIp == null) {
            header("HTTP/1.0 403 Forbidden");
	        exit();
        }
    }
    
}

?>
