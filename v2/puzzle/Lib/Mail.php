<?php

/*
 * Base/Mail.php - Copyright 2009 Dennis Cohn Muroy
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
 * @package /Lib/
 * @class Mail
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class Mail {
    
    private $_to = array();
    private $_subject = "";
    private $_body = "";
    private $_headers = "From: %s\r\nX-Mailer: php";
    private $_maximumMessages;
   
    /**
     * Mail class constructor.
     *
     * @param array $to List of destination e-mails addresses.
     * @param string $subject E-mail subject.
     * @param string $body E-mail body.
     * @param string $from Sender address
     * @param int $maxMsg Maximum number of messages that will be send.
     */
    public function __construct ($to, $subject, $body, $from = "", $maxMsg = 5) 
    {
        $this->_to = is_array($to)? $to : array();
        $this->_subject = is_string($subject)? $subject : "";
        $this->_body = is_string($body)? $body : "";
        $this->_header = (trim($from) != "")? sprintf($this->_header, $from) : "";
        $this->_maximumMessages = $maxMsg;
    }
    
    /**
     * Sends the email to the destination e-mail addresses.
     *
     * @return int how many e-mails were successfully sent.
     */
    public function send()
    {
        $totalCount = count($this->_to);
        $count = min($totalCount, $this->_maximumMessages);
        $success = 0;
        if ($this->validateMail($this->_headers)) {
            for ($i = 0; $i < $count; $i++) {
                $to = $this->_to[$i];
                if ($this->validate($to)) {
                    $value = mail($to, $this->_subject, $this->_body, $this->_headers);
                    if ($value === TRUE) {
                        ++$success;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
        }
        return $count - $success;
    }
    
    /**
     * Validates that the email address has a valid structure.
     *
     * @param string $email E-mail address to be validated.
     * @return boolean TRUE in case the $email parameter is an valid e-mail address.
     */
    private function validateMail ($email) 
    {
        $regexp = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
        return eregi($regexp, $email);
    }

}