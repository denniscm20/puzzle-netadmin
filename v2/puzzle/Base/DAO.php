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

require_once (PATH_LIB.'Database/Connection.php');

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
     * The name of the object.
     * @var String
     * @access protected
     */
    protected $objectName = "";
    /**
     * The connection to the data base.
     * @var Lib_Database_Connection
     * @access private
     */
    private $connection = null;

    /**
     * Class constructor.
     * @access protected
     * @param mixed $object Object name or object that contains the values
     * for being inserted/updated.
     */
    protected function __construct( $object ){
        if (is_string($object)) {
            $this->objectName = $object;
            $this->object = new $this->objectName ();
        } else {
            $this->object = $object;
            $this->objectName = get_class($this->object);
        }
        $this->connection = Lib_Database_Connection::getInstance();
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
     * Executes a query, defined in the $query attribute, against the database.
     * @final
     * @access private
     * @return PDO_Statement The PDO Statement for the query that has been
     * executed.
     */
    private final function executeQuery()
    {
        $connection = $this->connection->getConnection();
        $statement = $connection->prepare($this->query);
        if ($statement !== FALSE) {
            $result = FALSE;
            if (count($this->parameters) > 0) {
                $result = $statement->execute($this->parameters);
            } else {
                $result = $statement->execute();
            }
            if ($result !== FALSE) {
                return $statement;
            } else {
                return $result;
            }
        } else {
            echo "Error in Query: ".$this->query;
            // throw new PDOException("Error in Query: ".$this->query);
            exit;
        }
    }

    /**
     * Fetched a list of objects from the database.
     * @access private
     * @final
     * @return array A list of objects.
     */
    private final function retrieveObjectFromDatabase ( )
    {
        try {
            $objects = array();
            $statement = $this->executeQuery();
            if (!is_bool($statement)) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $r) {
                    $objects[] = $this->loadObject($r);
                }
            }
            return $objects;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Modifies the information stored in a table in the database.
     * @access private
     * @final
     * @return bool The query was successfully executed.
     */
    private final function saveObjectToDatabase ( ) {
        try {
            return $this->executeQuery();
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Loads the object's attributes retrieved from the database.
     * @access private
     * @final
     * @param ResultSet result Record from the database.
     * @return object Object with its attributes' values loaded.
     */
    private final function loadObject( $result )
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
        $object = $this->loadObjectReferences($object, $result);
        return $object;
    }


    /**
     * Limits the number of items returned by the query
     * @access private
     * @final
     * @param Integer $start
     * @param Integer $range
     * @return String
     */
    private final function limitQuery($start, $range = self::LIMIT_DEFAULT)
    {
        $str = "%s LIMIT %d, %d";
        $end = $start + $range;
        $this->query = sprintf($str, $this->query, $start, $end);
    }

    /**
     * Retrieves the las inserted Id in a table of the databaseś
     * @access protected
     * @final
     * @return Integer Last inserted Id in the database;
     */
    protected final function getLastId()
    {
        $pdo = $this->connection->getConnection();
        return $pdo->lastInsertId();
    }

    /**
     * Inserts or updates an object in the database
     *
     * @access protected
     * @author Dennis Cohn Muroy
     * @return Integer Last inserted/updated field id
     */
    protected function save()
    {
        try {
            if ($this->saveObjectToDatabase() !== FALSE) {
                if ($this->object->Id === 0) {
                    return $this->getLastId();
                } else {
                    return $this->object->Id;
                }
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return false;
        }
    }

    /**
     * Deletes an existing object from the database
     *
     * @access protected
     * @author Dennis Cohn Muroy
     * @return Boolean True if object was successfully deleted from database
     */
    protected function delete()
    {
        return $this->saveObjectToDatabase();
    }

    /**
     * Loads an object from its attributes values stored in the database
     *
     * @access protected
     * @author Dennis Cohn Muroy
     * @return Base_Class null on failure
     */
    protected function load()
    {
        $result = $this->retrieveObjectFromDatabase();
        if (count($result) > 0) {
            return $result[0];
        }
        return null;
    }

    /**
     * Lists a range of elements from the database.
     *
     * @access protected
     * @author Dennis Cohn Muroy
     * @param Integer $start first element of the list to retrieve
     * @param Integer $range Number of elements to retrieve
     * @return array List of elements retrieved from the database
     */
    protected function listObjects ( $start, $range = DEFAULT_LIST_LIMIT )
    {
        /** @todo Add boolean flag to indicate if there will be a limit */
        $this->limitQuery($start, $range);
        return $this->retrieveObjectFromDatabase();
    }

    /**
     * Loads the object's references with values from the database
     * @abstract
     * @access protected
     * @param Base_Class Object which has references to be loaded.
     * @param ResultSet $result Resultset which contains the list of values
     * from the database.
     * @return Base_Class
     */
    protected abstract function loadObjectReferences ($object, $result );

}

?>
