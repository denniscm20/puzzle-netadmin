<?php
/*
 * Base/DAO.php - Copyright 2009 Dennis Cohn Muroy
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

require_once (LIB_PATH.'DBConnection.php');

/**
 * Abstract class that implements the basic methods of the data access object class.
 * @abstract
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Base
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Base_DAO
{
    /**
     * Short description of attribute LIMIT_DEFAULT
     *
     * @access public
     * @var Integer
     */
    const LIMIT_DEFAULT = 10;
    /**
     * Short description of attribute MAX
     *
     * @access public
     * @var Integer
     */
    const MAX = null;
    /**
     * This attribute stores the query that will be executed against the database.
     * @var string
     * @access protected
     */
    protected $query = "";
    /**
     * This array stores the parameters that will be replaced in the query.
     * @var array
     * @access protected
     */
    protected $parameters = array();
    /**
     * The range of registers that will be returned from the query.
     * @var String
     * @access protected
     */
    protected $limit = "";
    /**
     * The object that contains the information that will be stored/updated in
     * the database.
     * @var Object
     * @access protected
     */
    protected $object = null;
    /**
     * The connection to the data base.
     * @var PDO
     * @access protected
     */
    protected $connection = null;

    /**
     * Class constructor.
     * @access protected
     * @param Object $object Object that contains the values for being
     * inserted/updated.
     */
    protected function __construct( $object ){
        $this->object = $object;
        $this->limit = "";
        $dbConnection = Lib_DBConnection::getInstance();
        $this->connection = $dbConnection->getConnection();
    }

    /**
     * Class Destructor.
     * @access protected
     */
    protected function __destruct() {
        unset($this->object);
        foreach ($this->parameters as $parameter) {
            unset ($parameter);
        }
        unset($this->parameters);
    }

    /**
     * Implements the select database function.
     * @access protected
     * @return array A list of objects.
     */
    protected function selectQuery ( )
    {
        try {
            $objects = array();
            $this->query .= $this->limit;
            $connection = $this->connection;
            $statement = $connection->prepare($this->query);
            if (count($this->parameters) > 0) {
                $statement->execute($this->parameters);
            } else {
                $statement->execute();
            }
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $r) {
                $objects[] = $this->loadObject($r);
            }
            return $objects;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Implements the insert/update/delete SQL functions
     * @access protected
     * @return bool The query was successfully executed.
     */
    protected function executeQuery() {
        try {
            $statement = $this->connection->prepare($this->query);
            if (count($this->parameters) > 0) {
                $statement->execute($this->parameters);
            } else {
                $statement->execute();
            }
            return true;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Loads the object.
     * @access protected
     * @param ResultSet result Record from the database.
     * @return object Object with its attributes' values loaded.
     */
    protected function loadObject( $result )
    {
        $className = get_class($this->object);
        $object = new $className();
        foreach ($result as $key => $value) {
            if (strpos($key, '_id') === false) {
                $setMethod = "set".ucfirst($key);
                $object->{$setMethod}($value);
            }
        }
        return $object;
    }

    /**
     * Sets the total amount ot records that the query will return.
     * @access public
     * @param integer start
     * @param integer max
     * @return boolean
     */
    public abstract function setLimits($start = 0, $max = DAO::LIMIT_DEFAULT);
    
    /**
     * Inserts a new object in the database.
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return Boolean
     */
    public abstract function insert();

    /**
     * Updates an existing object in the database
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return Boolean
     */
    public abstract function update();

    /**
     * Deletes an existing object from the database
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return Boolean
     */
    public abstract function delete();

    /**
     * Selects an object from the database
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return Base_Model
     */
    public abstract function select();

    /**
     * Lists a range of elements from the database.
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return array
     */
    public abstract function listElements();

}

?>
