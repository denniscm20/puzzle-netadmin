<?php
/*
 * Base/MessageHandler.php - Copyright 2009 Dennis Cohn Muroy
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

/**
 * This class contains the necessary methods for interacting with the messages
 * that will be displayed to the user.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Lib
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_MessagesHandler {

    const ERROR = "error";
    const INFORMATION = "information";
    const WARNING = "warning";

    /**
     * @static
     * @access private
     * @var Lib_MessagesHandler
     */
    private static $messageHandler = null;

    /**
     * Class Constructor
     * @access private
     */
    private function  __construct()
    {}

    /**
     * Clears the error messages to be displayed.
     * @access private
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     */
    private function clear()
    {
        $_SESSION[self::ERROR] = serialize(array());
        $_SESSION[self::INFORMATION] = serialize(array());
        $_SESSION[self::WARNING] = serialize(array());
        session_write_close();
    }

    /**
     * Registers a message.
     * @access private
     * @param string $msg Text of the message.
     * @param string $type Type of message.
     */
    private function addMessage ($msg, $type)
    {
        $array = null;
        if (isset($_SESSION[$type])) {
            $array = unserialize ($_SESSION[$type]);
        } else {
            $array = array();
        }
        $array[] = $msg;
        $_SESSION[$type] = serialize($array);
        session_write_close();
    }

    /**
     * Displays the area where the message will be printed
     * @access private
     * @param array $messageList List of messages.
     * @param string $type Type of message.
     */
    private function messageArea ($messageList, $type)
    {
        echo '<div class = "', $type,'">';
        echo join("<br/>", $messageList);
        echo '</div>';
    }

    /**
     * Retrieves a Lib_MessageHandler instance.
     * @static
     * @access public
     * @return Lib_MessagesHandler
     */
    public static function getInstance ()
    {
        if (self::$messageHandler == null) {
            self::$messageHandler = new Lib_MessagesHandler();
        }
        return self::$messageHandler;
    }

    /**
     * Registers an error message
     * @access public
     * @param string $msg Error message to be registered.
     */
    public function addError($msg)
    {
        $this->addMessage($msg, self::ERROR);
    }

    /**
     * Registers an information message
     * @access public
     * @param string $msg Information message to be registered.
     */
    public function addInformation($msg)
    {
        $this->addMessage($msg, self::INFORMATION);
    }

    /**
     * Registers a warning message
     * @access public
     * @param string $msg Warning message to be registered.
     */
    public function addWarning($msg)
    {
        $this->addMessage($msg, self::WARNING);
    }

    /**
     * Displays the system messages.
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     */
    public function showMessages()
    {
        $error = unserialize($_SESSION[self::ERROR]);
        $warning = unserialize($_SESSION[self::WARNING]);
        $info = unserialize($_SESSION[self::INFORMATION]);
        $this->messageArea($error, self::ERROR);
        $this->messageArea($warning, self::WARNING);
        $this->messageArea($info, self::INFORMATION);
        $this->clear();
    }
}
?>
