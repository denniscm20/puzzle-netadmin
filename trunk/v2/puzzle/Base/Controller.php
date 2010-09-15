<?php
/*
 * Base/Controller.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_LIB.'Cleaner.php';
require_once PATH_LIB.'Validator.php';
require_once PATH_LIB.'MessageHandler.php';

/**
 * Abstract class that implements the basic methods of the controller class.
 * @abstract
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Base
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Base_Controller
{

    // --- ASSOCIATIONS ---

    protected $elements = null;
    protected $allowedRoles = null;

    // --- ATTRIBUTES ---

    /**
     * Controller reference.
     *
     * @access protected
     * @var Controller
     */
    protected static $controller = null;

    /**
     * Url Identifier
     *
     * @access protected
     * @var String
     */
    protected $identifier = null;

    /**
     * Class constructor
     *
     * @access protected
     * @author Dennis Cohn Muroy
     */
    protected function __construct()
    {
        $this->elements = array();
        $this->allowedRoles = array();
    }

    /**
     * Class destructor.
     *
     * @access protected
     * @author Dennis Cohn Muroy
     * @return void
     */
    protected function __destruct()
    {
        foreach ($this->elements as $element) {
            unset($element);
        }
        unset($this->elements);
        foreach ($this->allowedRoles as $role) {
            unset($role);
        }
        unset($this->allowedRoles);
        self::$controller = null;
    }

    /**
     * Retrieves a Controller instance.
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @return Base_Controller
     */
    public static function getInstance($piece = "", $page = "")
    {
        if(!isset(self::$controller)) {
            $controllerName = "";
            if (!function_exists('get_called_class')) {
                $controllerName = sprintf(PIECE_PREFFIX, $piece, "Controller").$page."Controller";
            } else {
                $controllerName = get_called_class();
            }
            self::$controller = new $controllerName();
        }
        return self::$controller;
    }

    /**
     * Adds an element to the controller
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @param  String key
     * @param  Object value
     */
    public function add( $key, $value )
    {
        $this->elements[$key] = $value;
    }

    /**
     * Retrieves an element from the controller
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @param  String key
     * @return Object
     */
    public function get( $key )
    {
        if (isset($this->elements[$key])) {
            return $this->elements[$key];
        }
        return null;
    }
    
    /**
     * This method allows to determine if the user has privileges to see this page
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @param String $piece
     * @param String $page
     * @param String $event
     * @return Boolean
     */
    protected function hasPermissions($piece, $page)
    {
        if ($piece != DEFAULT_PIECE && $page != DEFAULT_LOGOUT_PAGE) {
            if (isset($_SESSION["User"]["Permissions"])) {
                $permissions = unserialize($_SESSION["User"]["Permissions"]);
                if (isset($permissions[$piece][$page])) {
                    return true;
                }
            }
            header("HTTP/1.0 403 Forbidden");
            exit();
        }
        return true;
    }
    
    /**
     * This method loads the permissions of each user per page according to the
     * role of the user.
     *
     * @access public
     * @author Dennis Cohn Muroy
     */
    protected function loadPermissions ()
    {
        if (!isset($_SESSION["User"]["Permissions"])) {
            $permissions = array();

            $_SESSION["User"]["Permissions"] = serialize($permissions);
        }
    }

    /**
     * Orders the controller to execute the event
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @param  String $event
     * @param  mixed $identifier
     */
    public function execute( $event, $identifier )
    {
        $this->identifier = $identifier;
        if ($this->validateInput()) {
            $event = $this->call($event);
            if (method_exists($this, $event)) {
                $this->{$event}();
            }
        }
        $this->loadElements();
    }

    /**
     * Stores the information related to the successful or unsuccessful login attempt
     * @access protected
     * @param string $username User that triggered the event.
     * @param int $type Error type.  Possible values are
     * Core_Model_Class_AccessLog::ACCESS_TYPE_FAILURE | ACCESS_TYPE_LOG_OUT |
     * ACCESS_TYPE_NOT_EXIST | ACCESS_TYPE_SUCCESS
     */
    protected function log($username, $type)
    {
        Lib_Helper::getDao("Core", "AccessLog");
        $accessLog = new Core_Model_Class_AccessLog();
        $accessLog->Username = Lib_Cleaner::clearString($username);
        $accessLog->Ip = Lib_Helper::getRemoteIP();
        $accessLog->AccessType = $type;
        $accesLogDAO = new Core_Model_Dao_AccessLogDAO($accessLog);
        $accesLogDAO->insert();
    }

    /**
     * Validates the input values provided by the user
     *
     * @abstract
     * @access protected
     * @author Dennis Cohn Muroy
     * @return Boolean True if the data was successfully cleaned and validated
     */
    protected abstract function validateInput();

    /**
     * Adds elements to the controller that will be required by the view
     *
     * @abstract
     * @access protected
     * @author Dennis Cohn Muroy
     */
    protected abstract function loadElements();

    /**
     * Returns the name of the method that will be executed
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy
     * @param  String event
     * @return Method name to execute
     */
    protected abstract function call( $event );
}

?>
