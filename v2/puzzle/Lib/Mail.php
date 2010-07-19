<?php

/*
 * Base/Mail.php - Copyright 2009 Dennis Cohn Muroy
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
 * @package /Lib/
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
class Lib_Mail
{
    
    private $_to = array();
    private $_from = "";
    private $_subject = "";
    private $_body = "";
    private $_headers = "From: %s\r\nX-Mailer: php";
    private $_maximumMessages;

    private $_socket = null;
   
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
        $this->_from = $from;
        $this->_subject = is_string($subject)? $subject : "";
        $this->_body = is_string($body)? $body : "";
        $this->_header = (trim($from) != "")? sprintf($this->_header, $from) : "";
        $this->_maximumMessages = $maxMsg;
        $this->_socket = null;
    }
    
    /**
     * Sends the email to the destination e-mail addresses.
     *
     * @return array List of mail addresses, the mail could not be sent to.
     */
    public function send()
    {
        $totalCount = count($this->_to);
        $count = min($totalCount, $this->_maximumMessages);
        $rejectedList = array();
        for ($i = 0; $i < $count; $i++) {
            $to = $this->_to[$i];
            if ($this->validateMailSyntax($to)) {
                $value = mail($to, $this->_subject, $this->_body, $this->_headers);
                if ($value === FALSE) {
                    $rejectedList[] = $to;
                }
            }
        }
        return $rejectedList;
    }
    
    /**
     * Validates that the email address has a valid structure.
     *
     * @param string $email E-mail address to be validated.
     * @return boolean TRUE in case the $email parameter is an valid e-mail address.
     */
    private function validateMailSyntax ($email)
    {
        $regexp = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
        return eregi($regexp, $email);
    }

    /**
     * Validate Email Addresses Via SMTP.
     * Original Source Code: 
     * <a href="http://www.webdigi.co.uk/blog/wp-content/uploads/2009/01/smtpvalidateclassphp.txt">
     * WEBDIGI
     * </a>
     * @link WEBDIGI
     * @author gabe@fijiwebdesign.com
     * @copyright http://creativecommons.org/licenses/by/2.0/ - Please keep this comment intact
     */
    public function validateMailExists ($port = 25, $timeout = 20, $readTimeout = 5)
    {
        $emailList = $this->sortEmails();
        $rejectedList = array();
        foreach ($emailList as $domain => $userList) {
            $mxList = $this->queryMX($domain);
            foreach ($mxList as $host => $weight) {
                if ($this->openSocket($host, $port, $timeout) !== FALSE) {
                    stream_set_timeout($this->_socket, $readTimeout);
                    $code = $this->readReply(true);
                    if ($code == '220') {
                        foreach ($userList as $user) {
                            $this->sendMessage("HELO ".substr($this->_from, strpos($this->_from, "@") + 1));
                            $this->sendMessage("MAIL FROM: <".EMAIL_ACCOUNT.">");
                            $this->sendMessage("RCPT TO: <".$user.'@'.$domain.">");
                            $code = $this->readReply(true);
                            if (($code != '250') && ($code != '451' && $code != '452')) {
                                $rejectedList[] = $user.'@'.$domain;
                            }
                        }
                        $this->sendMessage("quit");
                        $this->closeSocket();
                        break;
                    } else {
                        $this->sendMessage("quit");
                        $this->closeSocket();
                    }
                }
            }
        }
        return $rejectedList;
    }

    private function openSocket ($host, $port, $timeout)
    {
        $this->_socket = fsockopen($host, $port, $errno, $errstr, (float)$timeout);
        return $this->_socket !== FALSE;
    }

    private function closeSocket()
    {
        return fclose($this->_socket);
    }

    /**
     * Return a List of hashes containing the domain and its related usernames
     * @return array List of Hashes (Domain => List of Users)
     */
    private function sortEmails()
    {
        $emailList = array();
        foreach ($this->_to as $email) {
            if ($this->validateMailSyntax($email)) {
                $email = explode("@", $email);
                $user = $email[0];
                $domain = $email[1];
                $emailList[$domain][] = $user;
            }
        }
        return $emailList;
    }

    private function sendMessage($msg)
    {
        fwrite($this->sock, $msg."\r\n");
    }

    private function readReply($filterCode = false)
    {
        $reply = fread($this->sock, 2082);
        if ($filterCode === true) {
            preg_match('/^([0-9]{3}) /ims', $reply, $matches);
            return isset($matches[1]) ? $matches[1] : '';
        }
        return $reply;
    }

    /**
      * Query DNS server for MX entries
      * @param String $domain Domain name
      * @return array List of Hashes (Hostname => Weight)
      */
    private function queryMX($domain)
    {
        $hosts = array();
        $mxweights = array();
        $mxList = array();

        getmxrr($domain, $hosts, $mxweights);
        $count = count ($hosts);
        for($i = 0; $i < $count; $i++){
            $mxList[$hosts[$i]] = $mxweights[$i];
        }
        asort($mxList);
        $mxList[$domain] = 0;
        return $mxList;
    }
}