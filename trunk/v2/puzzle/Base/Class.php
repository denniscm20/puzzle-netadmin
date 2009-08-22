<?php
/*
 * Base/Class.php - Copyright 2009 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * tiny-weblog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * tiny-weblog is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with puzzle.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once PATH_LIB.'Validator.php';
require_once PATH_LIB.'MessageHandler.php';

/**
 * Application Base Class which contains the common methods for the application
 * model classes.
 * @abstract
 * @author Dennis Cohn Muroy
 * @package Base
 * @since 2009
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Base_Class
{

    /**
     * Represents the id of the object stored in the database.
     * @access private
     */
    private $id;

    /**
     * Class constructor
     * @return
     * @access protected
     */
    protected function __construct( )
    {
        $this->id = 0;
    } // end of member function __construct

    /**
     * Retrieves the Id of the class
     * @return int Id of the Object
     * @access public
     */
    public function getId( )
    {
        return $this->id;
    } // end of member function getId

    /**
     * Sets the class id
     * @param int id Class' id
     * @return
     * @access public
     */
    public function setId( $id )
    {
        if (Lib_Validator::validateInteger($id)) {
            $this->id = $id;
        }
    } // end of member function setId

    /**
     *
     * @param string name Attribute's name
     * @return string
     * @access public
     */
    public function __get( $name )
    {
        $function = "get".$name;
        if (method_exists($this, $function)) {
            return $this->{$function}();
        } else {
            throw new Exception($name ." is not a valid property");
        }
    } // end of member function __get

    /**
     *
     * @param string name Attribute's name.
     * @param string value Attrbute's value
     * @return
     * @access public
     */
    public function __set( $name,  $value )
    {
        $function = "set".$name;
        if (method_exists($this, $function)) {
            $this->{$function}($value);
        }  else {
            throw new Exception($name . " is not a valid property");
        }
    } // end of member function __set

    /**
     * Class destructor
     * @access protected
     */
    protected function __destruct( )
    {
        unset($this->id);
    } // end of member function __destruct

} // end of Class
?>
