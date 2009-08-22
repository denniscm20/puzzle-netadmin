<?php
/*
 * Base/Validator.php - Copyright 2009 Dennis Cohn Muroy
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

require_once (LIB_PATH.'MessageHandler.php');

/**
 * This class contains methods that allows you to validate through different
 * data types.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Lib
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_Validator
{
    
    /**
     * Validates that the parameter is a string that has a valid number of
     * characters.
     * @static
     * @access public
     * @param mixed $text string to validate
     * @param int $maxLenght Max number of characters that the string must have.
     * @return boolean
     */
    public static function validateString($text, $maxLenght = 10)
    {
        if (is_string($text)) {
            if (strlen($text) <= $maxLenght) {
                return true;
            }
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(sprintf(ERROR_STRING, $text, $maxLenght));
        return false;
    }

    /**
     * Validates that the parameter is a real
     * @static
     * @access public
     * @param mixed $number Real to validate
     * @return boolean
     */
    public static function validateReal ($number)
    {
        if (is_numeric($number)) {
            return true;
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(sprintf(ERROR_REAL,$number));
        return false;
    }

    /**
     * Validates that the parameter is a integer
     * @static
     * @access public
     * @param mixed $number Integer to validate
     * @param boolean $positive Indicates if the $number must be a positive value.
     * Default value is true.
     * @return boolean
     */
    public static function validateInteger ($number, $positive = true)
    {
        if (is_numeric($number) === true) {
            $number = (integer)$number;
            if (($positive === true) && ($number >= 0)) {
                return true;
            } else if (($positive === false) && ($number <= 0)) {
                return true;
            }
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(sprintf(ERROR_INT,$number));
        return false;
    }

    /**
     * Validates that the parameter is a boolean
     * @static
     * @access public
     * @param mixed $bool Boolean to validate
     * @return boolean
     */
    public static function validateBoolean ($bool)
    {
        $bool = (bool)$bool;
        if (is_bool($bool)) {
            return true;
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(sprintf(ERROR_BOOL,$bool));
        return false;
    }

    /**
     * Validates that the parameter is an object
     * @static
     * @access public
     * @param mixed $object Object to validate
     * @param String $objectName Object type
     * @return boolean
     */
    public static function validateObject ($object, $objectName)
    {
        if (is_object($object)) {
            if ($object instanceof $objectName) {
                return true;
            }
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(sprintf(ERROR_OBJECT, get_class($object), $objectName));
        return false;
    }
    
    /**
     * Validates that the parameter is a well-formed url
     * @static
     * @access public
     * @param String $url Text to validate
     * @return boolean
     */
    public static function validateURL ($url) 
    {
        $pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
        return preg_match($pattern, $url) > 0;
    }

    /**
     * Validates that the parameter is a valid date
     * @static
     * @access public
     * @param mixed $date Date to validate
     * @return boolean
     */
    public static function validateDate ($date)
    {
        $stamp = strtotime( $date );
        if (is_numeric($stamp)) {
            $month = date( 'm', $stamp );
            $day   = date( 'd', $stamp );
            $year  = date( 'Y', $stamp );
            if (checkdate($month, $day, $year)) {
                return TRUE;
            }
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError(sprintf(ERROR_DATE, $date));
        return FALSE;
    }

    /**
     * Validates that the parameter is an array and its elements are of the
     * specified type
     * @static
     * @access public
     * @param mixed $array Array to validate.
     * @param String $objectName If this parameter is especified, then each
     * element of the array is verified to be of the $objectName type.
     * @return boolean
     */
    public static function validateArray ($array, $objectName = "")
    {
        $error = "";
        if (is_array($array)) {
            if (trim($objectName) != "") {
                foreach ($array as $element) {
                    if (!Lib_Validator::validateObject($element, $objectName)) {
                        $error = sprintf(ERROR_ARRAY_OBJECT, $objectName);
                        break;
                    }
                }
            }
            if (trim($error) == "") {
                return true;
            }
        } else {
            $error = ERROR_ARRAY;
        }
        $messageHandler = Lib_MessagesHandler::getInstance();
        $messageHandler->addError($error);
        return false;
    }
 
    /**
     * Validates the parameter is a valid IPv4 address.
     * @static
     * @access public
     * @param string $ip Ipv4 Address to validate.
     * @return boolean
     */
    public static function validateIp4($ip) {
        $ipPattern = '/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.' .
                '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.' .
                '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.' .
                '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/';
        return preg_match($ipPattern, $ip) > 0;
    }

    /**
     * Validates that the parameter is a valid Short Mask
     * @static
     * @access public
     * @param string $shortMask
     * @return boolean
     */
    public static function validateShortMaskIpv4 ($shortMask) {
        if (is_numeric($shortMask)) {
            if ($shortMask >= 0 && $shortMask <= 32) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Validates that a short mask belongs to a mask
     * @static
     * @access public
     * @param string $mask pMascara Máscara en formato largo.
     * @param string $shortMask
     * @return boolean
     */
    public static function validateMaskIp4 ($mask, $shortMask) {
        if (Lib_Validator::validateIp4($mask) && Lib_Validator::validateShortMaskIpv4($shortMask)) {
            $values = explode(".", $mask);
            $maskNumber = 0;
            $count = count($values);
            for ($i = 0; $i < $count; $i ++) {
                $masquerade = 0x1;
                for ($j = 0; $j < 8; $j++) {
                    $bit = ($value[$i] >> (7 - $j)) & $masquerade;
                    if ($bit == 1) {
                        $maskNumber++;
                    }
                    if ($bit == 0 || (($j == 7) && ($i == 3))) {
                        return $maskNumber == $shortMask;
                    }
                }
            }
        }
        return false;
    }
    
    /**
     * Validates that an Ipv4 belongs to a subnet
     * @static
     * @access public
     * @param string $ip IP Address.
     * @param string $mask Subnet Mask.
     * @param string $subnet Subnet IP Address.
     * @return boolean
     */
    public static function validateIpBelongsSubnet($ip, $mask, $subnet) {
        $ip = explode(".",$ip);
        $mask = explode(".",$mask);
        $subnet = explode(".",$subnet);
        
        if (Lib_Validator::validateIp4($ip) && Lib_Validator::validateIp4($mask) && Lib_Validator::validateIp4($subnet)) {
            for ($i = 0; $i < 4; $i ++ ) {
                $masquerade = (int)$mask[$i];
                if (($ip[$i] & $masquerade) != ($subnet[$i] & $masquerade)) {
                    return false;
                }
            }
            return true;
        } 
        return false;
    }
    
    /**
     * Validates the Mask parameter has a valid IPv4 format
     * @static
     * @access public
     * @param string $mask
     * @return boolean
     */
    public static function validateMaskIp4($mask) {
        if (Lib_Validator::validateIp4($mask)) {
            $mask = explode(".", $mask);
            $oldBit = 1;
            foreach ($mask as $element) {
                $masquerade = 0x1;
                for ($i = 0; $i < 8; $i++) {
                    $bit = ((((int)$element) >> (7 - $i))) & $masquerade;
                    if (($oldBit == 0) && ($bit == 1)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
