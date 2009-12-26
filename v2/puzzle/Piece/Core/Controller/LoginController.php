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
        $this->isValidIp();
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

    /**
     * Logs the user into the system
     * @access protected
     */
    protected function login()
    {
        $username = isset($_POST["username"])?$_POST["username"]:"";
        $password = isset($_POST["password"])?$_POST["password"]:"";
        
        if ($this->validateInput($username, $password) === true) {
            $this->retrieveUser($username);
            if ($this->user == null) {
                $this->log(Core_Model_Class_AccessLog::ACCESS_TYPE_NOT_EXIST);
            } else {
                $this->verifyChangePassword();
                if ($this->verifyPassword($password)) {
                    $this->log(Core_Model_Class_AccessLog::ACCESS_TYPE_SUCCESS);
                    $this->grantAccess();
                } else {
                    $this->log(Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE);
                }
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
        	session_unset();
            $messageHandler = Lib_MessagesHandler::getInstance();
            if (session_destroy() !== false) {
                $messageHandler->addInformation(LOGIN_LOGOUT_INFO);
            } else {
                $messageHandler->addError(LOGIN_LOGOUT_ERROR);
            }
            $this->log(Core_Model_Class_AccessLog::ACCESS_TYPE_LOG_OUT);
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

    /**
     * Validates that the user and password provided do not have strange characters.
     * @access private
     * @param String $username Provided text plain Username
     * @param String $password Provided text plain Password
     * @return Boolean True if there were no validation errors
     */
    private function validateInput($username, $password)
    {
        $result = false;
        $cleanUsername = Lib_Cleaner::clearString($username);
        $cleanPassword = Lib_Cleaner::clearString($password);
        if ($username != "" && $username == $cleanUsername && $password == $cleanPassword) {
            $result = (Lib_Validator::validateString($cleanUsername, 20)) &&
                      (Lib_Validator::validateString($cleanPassword, 210));
        }
        return $result;
    }

    /**
     * Retrieves an account object
     * @access private
     * @param String $username TExt plain username
     */
    private function retrieveUser($username)
    {
        Lib_Helper::getDao("Core", "Account");
        $this->user->Username = $username;
        $this->user->Enabled = true;
        $accountDAO = new Core_Model_Dao_AccountDAO($this->user);
        $this->user = $accountDAO->selectByUsernameAndEnabled();
    }

    /**
     * Validates if the changePassword flag is active.
     * @access private
     */
    private function verifyChangePassword()
    {
        $changePasword =  $this->user->ChangePassword;
        if ($changePasword == true) {
            $_SESSION["User"]["Account"] = serialize($this->user);
            session_write_close();
            Lib_Helper::redirect("Core", "Account");
        }
    }

    /**
     * Validates if the password provided matches the stored one.
     * @access private
     * @param String $inputPassword Text plain password
     * @return Boolean Trus if the stored and provided password matches
     */
    private function verifyPassword($inputPassword)
    {
        $password = $this->user->Password;
        $salt = $this->user->Salt;
        $currentpassword = $salt.$inputPassword;
        $cypher = hash("sha512", $currentpassword);
        return ($password == $cypher);
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
     * Stores the information related to the successful or unsuccessful login attempt
     * @access private
     * @param int $type Error type.  Possible values are
     * Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE | ACCESS_TYPE_LOG_OUT |
     * ACCESS_TYPE_NOT_EXIST | ACCESS_TYPE_SUCCESS
     */
    private function log($type)
    {
        Lib_Helper::getDao("Core", "AccessLog");
        $accessLog = new Core_Model_Class_AccessLog();
        $accessLog->Username = Lib_Cleaner::clearString($_POST["username"]);
        $accessLog->Ip = Lib_Helper::getRemoteIP();
        $accessLog->AccessType = $type;
        $accesLogDAO = new Core_Model_Dao_AccessLogDAO($accessLog);
        $accesLogDAO->insert();
    }
    
}

?>
