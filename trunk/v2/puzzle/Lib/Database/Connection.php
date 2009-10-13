<?php
/*
 * Lib/Database/Connection.php - Copyright 2009 Dennis Cohn Muroy
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

/**
 * Creates the database connection.
 * @abstract
 * @package Lib
 * @subpackage Database
 * @author Dennis Cohn Muroy
 * @version 1.0
 * @copyright Copyright (c) 2009, Dennis Cohn Muroy
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Lib_Database_Connection
{

    /**
     * The Lib_Database_Connection object instance
     * @var Lib_Database_Connection
     * @access protected
     * @static
     */
    protected static $connection = null;

    /**
     * The database connection
     * @var PDO
     * @access protected
     */
    protected $databaseConnection = null;
    
    /**
     * Class constructor
     * @access protected
     */
    protected function __construct()
    {
        $dns = $this->buildDns();
        $user = DB_USER;
        $password = DB_PASSWORD;

        $this->databaseConnection = null;
        try {
            $this->databaseConnection = new PDO ($dns, $user, $password);
        } catch (Exception $ex) {
        	throw $ex;
        }
    }


    /**
     * Retrieves a DBConnection instance.
     * @abstract
     * @access public
     * @return DBConnection Connection instance.
     */
    public static function getInstance()
    {
        $file = PATH_LIB.'Database/'.DB_TYPE.'.php';
        if (file_exists($file)) {
            require_once $file;
            if (self::$connection == null) {
                $className = "Lib_Database_".DB_TYPE;
                self::$connection = new $className ();
            }
            return self::$connection;
        } else {
            throw new Exception();
        }
    }

    /**
     * Builds the dns needed to start the connection.
     * @abstract
     * @access protected
     * @return String.
     */
    protected abstract function buildDns();

    /**
     * Limit the number of items returned by the query
     * @param String $query
     * @param Integer $start
     * @param Integer $range
     * @return String
     */
    public abstract function limitQuery($query, $start, $range);
    
    /**
     * Retrieves a Connection to a Master or a Single Data Base
     * @access public
     * @return PDO Connection to a Master or a Single Data Base
     */
    public function getConnection() {
    	return $this->databaseConnection;
    }

    /**
     * Class destructor
     * @access protected
     */
    protected function __destruct()
    {
        self::$connection = null;
        unset($this->databaseConnection);
    }
}

?>
