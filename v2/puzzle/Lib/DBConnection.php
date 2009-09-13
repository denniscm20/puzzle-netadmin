<?php
/*
 * Base/DBConnection.php - Copyright 2009 Dennis Cohn Muroy
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
 * Creates the database master and Slave connections.
 * @abstract
 * @author Dennis Cohn Muroy
 * @version 1.0
 * @copyright Copyright (c) 2009, Dennis Cohn Muroy
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Lib_DBConnection
{
    /**
     * Indicates if a connection has been created
     * @var boolean
     * @access protected
     * @static
     */
    protected static $connectionCreated = null;

    /**
     * The master or single database connection
     * @var PDO
     * @access protected
     */
    protected $dbConnection = null;
    
    /**
     * Class constructor
     * @access protected
     */
    protected function __construct()
    {
        $dns = $this->dns;
        $user = DB_USER;
        $password = DB_PASSWORD;

        $pdo = null;
        try {
            $pdo = new PDO ($dns, $user, $password);
        } catch (Exception $ex) {
        	throw $ex;
        }

        return $pdo;
    }


    /**
     * Retrieves a DBConnection instance.
     * @abstract
     * @static
     * @access public
     * @return DBConnection Connection instance.
     */
    public abstract static function getInstance();
    
    /**
     * Retrieves a Connection to a Master or a Single Data Base
     * @access public
     * @return PDO Connection to a Master or a Single Data Base
     */
    public function getConnection() {
    	return $this->dbConnection;
    }

    /**
     * Class destructor
     * @access protected
     */
    protected function __destruct()
    {
        unset($this->dbConnection);
    }
}

?>
