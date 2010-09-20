<?php
/*
 * Iptables/Model/Class/Policy.php - Copyright 2010 Dennis Cohn Muroy
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
 * Class that implements the policy of the iptables Chains
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Iptables
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Iptables_Model_Class_Policy extends Base_Class
{

    /*** Attributes: ***/
    private $name = "";

    public function __construct() 
    {
        parent::__construct();
        $this->name = "";
    }
    
    public function __destruct()
    {
        parent::__destruct();
    }
}
?>
