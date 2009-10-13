<?php
/*
 * Base/DAO.php - Copyright 2009 Dennis Cohn Muroy
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

require_once (PATH_LIB.'Database/'.DB_TYPE.'.php');

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
     * The object that contains the information that will be stored/updated in
     * the database.
     * @var Object
     * @access protected
     */
    protected $object = null;
    /**
     * The connection to the data base.
     * @var Lib_Database_Connection
     * @access private
     */
    private $connection = null;

    /**
     * Class constructor.
     * @access protected
     * @param Object $object Object that contains the values for being
     * inserted/updated.
     */
    protected function __construct( $object ){
        $this->object = $object;
        eval ("\$this->connection = Lib_Database_".DB_TYPE."::getInstance();");
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
     * Limit the number of items returned by the query
     * @access protected
     * @final
     * @param Integer $start
     * @param Integer $range
     * @return String
     */
    protected final function limitQuery($start, $range = self::LIMIT_DEFAULT)
    {
        $this->query = $this->connection->limitQuery($this->query, $start, $range);
    }

    /**
     * Implements the select database function.
     * @access protected
     * @final
     * @return array A list of objects.
     */
    protected final function selectQuery ( )
    {
        try {
            $objects = array();
            $connection = $this->connection->getConnection();
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
     * @final
     * @return bool The query was successfully executed.
     */
    protected final function executeQuery() {
        try {
            $connection = $this->connection->getConnection();
            $statement = $connection->prepare($this->query);
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
            if (strpos($key, 'id_') === false) {
                $setMethod = "set".ucfirst($key);
                if (method_exists($object, $setMethod)) {
                    $object->{$setMethod}($value);
                }
            }
        }
        return $object;
    }

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
     * @param Integer $start first element of the list to retrieve
     * @param Integer $range Number of elements to retrieve
     * @return array
     */
    public abstract function listElements($start, $range);

}

?>
