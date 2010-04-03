<?php
/*
 * Base/Command.php - Copyright 2009 Dennis Cohn Muroy
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
 * Application Base Command Class which contains the common methods for
 * developing classes that makes use of system calls.
 * @abstract
 * @author Dennis Cohn Muroy
 * @package Base
 * @since 2010
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Base_Command extends Base_Class {

    protected $command;
    protected $parameters;

    protected function __construct()
    {
        parent::__construct();
        $this->command = "";
        $this->parameters = "";
    }

    protected function __destruct()
    {
        parent::__destruct();
    }

    protected function getCommand()
    {
        return $this->command;
    }

    protected function setCommand($command)
    {
        $this->command = $command;
    }

    protected function getParameters()
    {
        return $this->parameters;
    }

    protected function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Executed the command defined in the $command attribute, making use of the
     * parameters set in the $parameters attribute.
     * @access protected
     * @return Array command output
     */
    protected function executeCommand ()
    {
        $command = $this->command." ".$this->parameters;
        $result = shell_exec($command);
        $result = $this->parseOutput(trim($result));
        return $result;
    }

    /**
     * Parses the output of the exectued command
     * @abstract
     * @access protected
     * @param String $result Output to be parsed.
     * @return Array Parsed output
     */
    abstract protected function parseOutput($result);

}
?>
