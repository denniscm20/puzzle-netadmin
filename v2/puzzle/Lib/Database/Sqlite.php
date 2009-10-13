<?php
/*
 * Lib/Database/Connection.php - Copyright 2009 Dennis Cohn Muroy
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
 * Creates the sqlite database connection.
 * @abstract
 * @package Lib
 * @subpackage Database
 * @author Dennis Cohn Muroy
 * @version 1.0
 * @copyright Copyright (c) 2009, Dennis Cohn Muroy
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Lib_Database_Sqlite extends Lib_Database_Connection {

    protected function __construct ()
    {
        parent::__construct();
    }

    public function  __destruct()
    {
        parent::__destruct();
    }

    public function limitQuery($query,$start,$range)
    {
        if (strpos(strtoupper($query), "SELECT") == 0) {
            $str = "%s LIMIT %d, %d";
            $end = $start + $range;
            $query = sprintf($str, $query, $start, $end);
        }
        return $query;
    }
    
    protected function buildDns()
    {
        $dns = "sqlite:".PATH_DATABASE.DB_NAME;
        return $dns;
    }
}

?>
