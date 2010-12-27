<?php

/*
 * Lib/Network.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_LIB.'Validator.php';

/**
 * This class contains methods that allows you to work with network related
 * functions.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Lib
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_Network
{

    private $ip = "";
    private $mask = "";
    private $shortMask = 0;

    private $ipv4 = null;

    /**
     * Class Constructor
     * @access public
     * @param String $ip Valid ipv4 or ipv6 address.
     * @param String $mask Valid ipv4 or ipv6 mask address.
     */
    public function  __construct($ip = "", $mask = "")
    {
        $this->ip = $ip;
        $this->mask = $mask;
        $this->shortMask = 0;

        if (! $this->validParameters()) {
            debug_print_backtrace();
            throw new Exception("Non valid parameters");
        }
    }

    private function validParameters ()
    {
        $ipv4 = false;
        if (trim($this->ip) != "") {
            $this->isValidIP($this->ip);
            $this->ipv4 = $this->isIPv4($this->ip);
        }
        if (trim($this->mask) != "") {
            $this->isValidIP($this->mask);
        }
        return true;
    }

    public function isValidIP ($ip)
    {
        $result = filter_var($ip, FILTER_VALIDATE_IP);
        return ($result == $ip);
    }

    public function maskToShortMask ($mask)
    {
        if ($this->isValidIP($mask)) {
            if ($this->isIPv4($mask)) {
                return $this->maskToShortMaskIPv4($mask);
            } else {
                return $this->maskToShortMaskIPv6($mask);
            }
        }
        return false;
    }

    public function isValidShortMask ($shortMask, $ipv4 = true)
    {
        if (is_numeric($shortMask)) {
            if ($shortMask >= 0) {
                if (($shortMask <= 32 && $ipv4 === true) || ($shortMask <= 128 && $ipv4 === false)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isValidMask ($mask)
    {
        if ($this->isValidIP($mask)) {
            if ($this->isIPv4($mask)) {
                return $this->isValidIPv4Mask($mask);
            } else {
                return $this->isValidIPv6Mask($mask);
            }
        }
        return false;
    }

    public function isIPInSubnet ($ip, $mask, $subnet)
    {

    }

    public function maskMatchesShortMask ($mask, $shortMask)
    {
        if ($this->isValidIP($mask)) {
            if ($this->isIPv4($mask)) {
                return $this->maskMatchesShortMaskIPv4($mask, $shortMask);
            } else {
                return $this->maskMatchesShortMaskIPv6($mask, $shortMask);
            }
        }
        return false;
    }

    private function isIPv4 ($value)
    {
        $result = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if ($result === false) {
            $result = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
            if ($result === false) {
                return false;
            }
            return -1;
        }
        return true;
    }

    private function maskToShortMaskIPv4 ($mask)
    {
        $elements = explode(".",$mask);
        $count = count($elements);
        $shortMask = 0;

        foreach ($elements as $byte) {
            $masquerade = 0x1;
            for ($i = 0; $i < 8; $i ++) {
                $bit = ($byte >> (7 - $i)) & $masquerade;
                if ($bit != 0) {
                    ++$shortMask;
                } else {
                    return $shortMask;
                }
            }
        }
        return $shortMask;
    }

    private function maskToShortMaskIPv6 ($mask)
    {

    }

    private function isValidIPv4ShortMask ($shortMask)
    {

    }

    private function isValidIPv6ShortMask ($shortMask)
    {

    }

    public function maskMatchesShortMaskIPv4 ($mask, $shortMask)
    {
        if ($this->isValidIPv4ShortMask($shortMask)) {
            $expectedShortMask = $this->maskMatchesShortMaskIPv4($mask, $shortMask);
            return ($expectedShortMask == $shortMask);
        }
        return false;
    }

    public function maskMatchesShortMaskIPv6 ($mask, $shortMask)
    {

    }

    private function isValidIPv4Mask ($mask)
    {
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

    private function isValidIPv6Mask ($mask)
    {

    }

    public function isIPv4InSubnet ($ip, $mask, $subnet)
    {
        if ($this->isIPv4($mask)) {
            $ip = explode(".",$ip);
            $mask = explode(".",$mask);
            $subnet = explode(".",$subnet);
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

    public function isIPv6InSubnet ($ip, $mask, $subnet)
    {

    }

    public static function getHostByIP ($ip)
    {
        return gethostbyaddr($ip);
    }

    public static function getIPByHost ($host)
    {
        return gethostbyname($host);
    }
}
?>


<?php

/**
 * IPv6 Address Functions for PHP
 *
 * Functions to manipulate IPv6 addresses for PHP
 *
 * Copyright (C) 2009 Ray Patrick Soucy
 *
 * LICENSE:
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   inet6
 * @author    Ray Soucy <rps@soucy.org>
 * @version   1.0.1
 * @copyright 2009 Ray Patrick Soucy
 * @link      http://www.soucy.org/
 * @license   GNU General Public License version 3 or later
 * @since     File available since Release 1.0.1
 */

 /**
  * Expand an IPv6 Address
  *
  * This will take an IPv6 address written in short form and expand it to include all zeros.
  *
  * @param  string  $addr A valid IPv6 address
  * @return string  The expanded notation IPv6 address
  */
function inet6_expand($addr)
{
    /* Check if there are segments missing, insert if necessary */
    if (strpos($addr, '::') !== false) {
        $part = explode('::', $addr);
        $part[0] = explode(':', $part[0]);
        $part[1] = explode(':', $part[1]);
        $missing = array();
        for ($i = 0; $i < (8 - (count($part[0]) + count($part[1]))); $i++)
            array_push($missing, '0000');
        $missing = array_merge($part[0], $missing);
        $part = array_merge($missing, $part[1]);
    } else {
        $part = explode(":", $addr);
    } // if .. else
    /* Pad each segment until it has 4 digits */
    foreach ($part as &$p) {
        while (strlen($p) < 4) $p = '0' . $p;
    } // foreach
    unset($p);
    /* Join segments */
    $result = implode(':', $part);
    /* Quick check to make sure the length is as expected */
    if (strlen($result) == 39) {
        return $result;
    } else {
        return false;
    } // if .. else
} // inet6_expand

 /**
  * Compress an IPv6 Address
  *
  * This will take an IPv6 address and rewrite it in short form.
  *
  * @param  string  $addr A valid IPv6 address
  * @return string  The address in short form notation
  */
function inet6_compress($addr)
{
    /* PHP provides a shortcut for this operation */
    $result = inet_ntop(inet_pton($addr));
    return $result;
} // inet6_compress

 /**
  * Generate an IPv6 mask from prefix notation
  *
  * This will convert a prefix to an IPv6 address mask (used for IPv6 math)
  *
  * @param  integer $prefix The prefix size, an integer between 1 and 127 (inclusive)
  * @return string  The IPv6 mask address for the prefix size
  */
function inet6_prefix_to_mask($prefix)
{
    /* Make sure the prefix is a number between 1 and 127 (inclusive) */
    $prefix = intval($prefix);
    if ($prefix < 0 || $prefix > 128) return false;
    $mask = '0b';
    for ($i = 0; $i < $prefix; $i++) $mask .= '1';
    for ($i = strlen($mask) - 2; $i < 128; $i++) $mask .= '0';
    $mask = gmp_strval(gmp_init($mask), 16);
    for ($i = 0; $i < 8; $i++) {
        $result .= substr($mask, $i * 4, 4);
        if ($i != 7) $result .= ':';
    } // for
    return inet6_compress($result);
} // inet6_prefix_to_mask

 /**
  * Convert an IPv6 address and prefix size to an address range for the network.
  *
  * This will take an IPv6 address and prefix and return the first and last address available for the network.
  *
  * @param  string  $addr A valid IPv6 address
  * @param  integer $prefix The prefix size, an integer between 1 and 127 (inclusive)
  * @return array   An array with two strings containing the start and end address for the IPv6 network
  */
function inet6_to_range($addr, $prefix)
{
    $size = 128 - $prefix;
    $addr = gmp_init('0x' . str_replace(':', '', inet6_expand($addr)));
    $mask = gmp_init('0x' . str_replace(':', '', inet6_prefix_to_mask($prefix)));
    $prefix = gmp_and($addr, $mask);
    $start = gmp_strval(gmp_add($prefix, '0x1'), 16);
    $end = '0b';
    for ($i = 0; $i < $size; $i++) $end .= '1';
    $end = gmp_strval(gmp_add($prefix, gmp_init($end)), 16);
    for ($i = 0; $i < 8; $i++) {
        $start_result .= substr($start, $i * 4, 4);
        if ($i != 7) $start_result .= ':';
    } // for
    for ($i = 0; $i < 8; $i++) {
        $end_result .= substr($end, $i * 4, 4);
        if ($i != 7) $end_result .= ':';
    } // for
    $result = array(inet6_compress($start_result), inet6_compress($end_result));
    return $result;
} // inet6_to_range

 /**
  * Convert an IPv6 address to two 64-bit integers.
  *
  * This will translate an IPv6 address into two 64-bit integer values for storage in an SQL database.
  *
  * @param  string  $addr A valid IPv6 address
  * @return array   An array with two strings containing the 64-bit interger values
  */
function inet6_to_int64($addr)
{
    /* Expand the address if necessary */
    if (strlen($addr) != 39) {
        $addr = inet6_expand($addr);
        if ($addr == false) return false;
    } // if
    $addr = str_replace(':', '', $addr);
    $p1 = '0x' . substr($addr, 0, 16);
    $p2 = '0x' . substr($addr, 16);
    $p1 = gmp_init($p1);
    $p2 = gmp_init($p2);
    $result = array(gmp_strval($p1), gmp_strval($p2));
    return $result;
} // inet6_to_int64()

 /**
  * Convert two 64-bit integer values into an IPv6 address
  *
  * This will translate an array of 64-bit integer values back into an IPv6 address
  *
  * @param  array  $val An array containing two strings representing 64-bit integer values
  * @return string An IPv6 address
  */
function int64_to_inet6($val)
{
    /* Make sure input is an array with 2 numerical strings */
    $result = false;
    if ( ! is_array($val) || count($val) != 2) return $result;
    $p1 = gmp_strval(gmp_init($val[0]), 16);
    $p2 = gmp_strval(gmp_init($val[1]), 16);
    while (strlen($p1) < 16) $p1 = '0' . $p1;
    while (strlen($p2) < 16) $p2 = '0' . $p2;
    $addr = $p1 . $p2;
    for ($i = 0; $i < 8; $i++) {
        $result .= substr($addr, $i * 4, 4);
        if ($i != 7) $result .= ':';
    } // for
    return inet6_compress($result);
} // int64_to_inet6()


?>