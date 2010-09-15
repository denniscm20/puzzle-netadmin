<?php

/*
 * Core/Model/Class/Account.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements an user account in the system.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Core
 * @subpackage Model
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Core_Model_Class_Account extends Base_Class {

    /**
     * User account role
     * @var Core_Model_Class_Role
     * @access private
     */
    private $role;

    /**
     * Account Creator
     * @var Core_Model_Class_Account
     * @access private
     */
    private $accountCreator;

    /**
     * Last user who modified the account
     * @var Core_Model_Class_Account
     * @access private
     */
    private $accountModifier;

    private $username;
    private $email;
    private $token;
    private $salt;
    private $password;
    private $changePassword;
    private $enabled;
    private $tokenDate;
    private $createdDate;
    private $modifiedDate;

    /**
     * Class Constructor
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $className = Lib_Helper::getClass("Core", "Role");

        $this->role = new $className();
        $this->accountCreator = null;
        $this->accountModifier = null;

        $this->username = "";
        $this->email = "";
        $this->token = "";
        $this->salt = "";
        $this->password = "";
        $this->changePassword = false;
        $this->enabled = true;
        $this->tokenDate = $this->createdDate = $this->modifiedDate = time();
    }

    /**
     * Class Destructor
     * @access public
     */
    public function  __destruct()
    {
        parent::__destruct();
        unset($this->role);
        unset($this->accountCreator);
        unset($this->accountModifier);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getAccountCreator()
    {
        return $this->accountCreator;
    }
        
    public function getAccountModifier()
    {
        return $this->accountModifier;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getChangePassword()
    {
        return $this->changePassword;
    }
    
    public function getEnabled()
    {
        return $this->enabled;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    public function setRole($role)
    {
        if (Lib_Validator::validateObject($role, 'Core_Model_Class_Role')) {
            $this->role = $role;
        }
    }

    public function setAccountCreator($account)
    {
        if (Lib_Validator::validateObject($account, 'Core_Model_Class_Account')) {
            $this->accountCreator = $account;
        }
    }

    public function setAccountModifier($account)
    {
        if (Lib_Validator::validateObject($account, 'Core_Model_Class_Account')) {
            $this->accountModifier = $account;
        }
    }

    public function setUsername($username)
    {
        if (Lib_Validator::validateString($username, 20)) {
            $this->username = $username;
        }
    }

    public function setSalt($salt)
    {
        if (Lib_Validator::validateString($salt, 20)) {
            $this->salt = $salt;
        }
    }

    public function setPassword($password)
    {
        if (Lib_Validator::validateString($password, 210)) {
            $this->password = $password;
        }
    }

    public function setChangePassword($changePassword)
    {
        if (Lib_Validator::validateBoolean($changePassword)) {
            $this->changePassword = $changePassword;
        }
    }

    public function setEnabled($enabled)
    {
        if (Lib_Validator::validateBoolean($enabled)) {
            $this->enabled = $enabled;
        }
    }

    public function setCreatedDate($createdDate)
    {
        if (Lib_Validator::validateInteger($createdDate, true)) {
            $this->createdDate = $createdDate;
        }
    }

    public function setModifiedDate($modfiedDate)
    {
        if (Lib_Validator::validateInteger($modfiedDate, true)) {
            $this->modifiedDate = $modfiedDate;
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (Lib_Validator::validateEmail($email)) {
            $this->email = $email;
        }
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        if (Lib_Validator::validateString($token, 210)) {
            $this->token = $token;
        }
    }

    public function getTokenDate() {
        return $this->tokenDate;
    }

    public function setTokenDate($tokenDate) {
        if (Lib_Validator::validateInteger($tokenDate, true)) {
            $this->tokenDate = $tokenDate;
        }
    }
    
    /**
     * Validates if the $password parameter matches the current account password.
     * @access public
     * @param $password String Password to be validated.
     * @return Boolean True if login was success
     */
    public function validatePassword($password)
    {
        $inputPassword = $this->salt.$password;
        $cypher = hash("sha512", $inputPassword);
        return ($inputPassword == $this->password);
    }

    /**
     * Validates if the $token parameter matches the current account token.
     * @access public
     * @param $password String Password to be validated.
     * @return Boolean True if login was success
     */
    public function validateToken($token)
    {
        $days = Lib_Helper::diffDates($this->tokenDate, time());
        if ($days <= DEFAULT_TOKEN_LIFETIME and $this->changePassword == true) {
            $inputToken = $this->username.$this->salt.$token;
            $cypher = hash("sha512", $inputToken);
        }
        return ($inputToken == $this->token);
    }

    /**
     * Generates the token
     * @access public
     * @return String Token generated
     */
    public function generateToken()
    {
        $salt = $this->generateSalt();
        $token = hash("md5", $salt . time());
        $inputToken = $this->username.$salt.$token;
        $this->token = hash("sha512", $inputToken);
        $this->tokenDate = date("Y-M-D H:i:s");
        return $token;
    }
    
    /**
     * Generates the password and the salt for the current user
     * @access public
     * @return String Password generated
     */
    public function generatePassword()
    {
        $salt = $this->generateSalt();
        $password = substring(hash("md5", $salt . time()), 0, 20);
        $this->password = hash("sha512", $salt.$password);
        $this->modifiedDate = date("Y-M-D H:i:s");
        return $password;
    }

    /**
     * Generates a random salt
     * @access private
     * @return String Salt generated
     */
    private function generateSalt()
    {
        if ($this->salt === "") {
            $this->salt = substr(hash("md5", time()), 0, 20);
        }
        return $this->salt;
    }

}
?>
