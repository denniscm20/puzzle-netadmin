<?php
/*
 * Piece/Core.php - Copyright 2010 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * [Project Name] is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * [Project Name] is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with puzzle.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * TBA: Class Description
 * @author Dennis Cohn Muroy
 * @package Piece
 * @since 2010
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Piece_Core
{

    public function __construct()
    {
        
    }
    
    public function ifconfig()
    {
        $command = "/sbin/ifconfig -a";
        passthru($command);
    }
    
    public function forward($forward)
    {
        $command = "echo ".$forward." | /usr/bin/tee /proc/sys/net/ipv4/ip_forward";
        passthru($command);
    }
    
    public function hostname()
    {
        $command = "hostname";
        passthru($command);
    }
    
    public function disk()
    {
        $command = "df -m";
        passthru($command);
    }        
}
?>
