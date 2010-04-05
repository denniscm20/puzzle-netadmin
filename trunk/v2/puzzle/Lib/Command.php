<?php
/*
 * Lib/Command.php - Copyright 2010 Dennis Cohn Muroy
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
 * Application  Helper Command Class which contains the common methods
 * that makes use of system calls.
 * @author Dennis Cohn Muroy
 * @package Base
 * @since 2010
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_Command {

    /**
     * Command to be executed
     * @var String
     * @access private
     */
    private $command;

    /**
     * Parameters that the command will receive
     * @var String
     * @access private
     */
    private $parameters;

    /**
     * Class Constructor
     * @param String $command Command to be executed.
     * @param String $parameters Optional parameter. Parameters of the command
     * that will be executed.
     */
    public function __construct($command, $parameters = "")
    {
        if (is_string($command) && is_string($parameters)) {
            /**
             * @todo Filter the command and parameters values
             */
            $this->command = $command;
            $this->parameters = $parameters;
        }
    }

    /**
     * Executed the command defined in the $command attribute, making use of the
     * parameters set in the $parameters attribute.
     * @access public
     * @return Array command output
     */
    public function execute ()
    {
        $command = $this->command." ".$this->parameters;
        $result = shell_exec($command);
        $result = $this->parseOutput(trim($result));
        return $result;
    }

    /**
     * Parses the output of the exectued command
     * @access protected
     * @param String $result Output to be parsed.
     * @return Array Parsed output
     */
    protected function parseOutput($result)
    {
         return split("\n", $result);
    }
}
?>
