<?php
/*
 * Piece/Iptables.php - Copyright 2010 Dennis Cohn Muroy
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
 * TBA: Class Description
 * @author Dennis Cohn Muroy
 * @package Piece
 * @since 2010
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Piece_Iptables
{
    public function saveRules($fileName)
    {
        $command = "/sbin/iptables-save > %s";
        $command = sprintf($command, $fileName);
        passthru($command);
    }
    
    public function restoreRules($fileName)
    {
        $command = "/sbin/iptables-restore < %s";
        $command = sprintf($command, $fileName);
        passthru($command);
    }
}
?>
