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
     * Class constructor
     *
     * @access protected
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
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
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
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
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
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
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
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
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
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
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @param string $role Role of the user who is trying to view this page.
     * @return Boolean
     */
    public function hasPermissions( $role )
    {
        if (!in_array($role, $this->allowedRoles) === true) {
            header("HTTP/1.0 403 Forbidden");
	        exit();
        }
    }

    /**
     * Adds elements to the controller that will be required by the view
     *
     * @abstract
     * @access protected
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     */
    protected abstract function loadElements();

    /**
     * Indicates which is the action that will be executed.
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @param  String event
     */
    public abstract function execute( $event );
}

?>
