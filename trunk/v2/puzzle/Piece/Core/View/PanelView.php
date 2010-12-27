<?php
/*
 * Core/View/PanelView.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_BASE.'View.php';

/**
 * Class that implements the application Panel View.
 * @package Core
 * @subpackage View
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_View_PanelView extends Base_View
{
    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Class Constructor
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @param  Controller controller
     * @return void
     */
    public function __construct($controller)
    {
        parent::__construct($controller, LOGIN_TITLE);
    }

    /**
     * Class Destructor.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return void
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Displays the page main content.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return void
     */
    public function show()
    {
        ?>
        <ul id="central-panel-menu">
            <li class="panel-item">
                <a href="">
                    <img src="<?php echo Lib_Helper::getImage("boton/server_info.png") ?>" alt="[SERVER INFO]" />
                    <br />
                    <span><?php echo PANEL_SERVER; ?></span>
                </a>
            </li>
            <li class="panel-item">
                <a href="">
                    <img src="<?php echo Lib_Helper::getImage("boton/module.png") ?>" alt="[SERVER INFO]" />
                    <br />
                    <span><?php echo PANEL_PIECES; ?></span>
                </a>
            </li>
            <li class="panel-item">
                <a href="">
                    <img src="<?php echo Lib_Helper::getImage("boton/network.png") ?>" alt="[SERVER INFO]" />
                    <br />
                    <span><?php echo PANEL_NETWORK; ?></span>
                </a>
            </li>
            <li class="panel-item">
                <a href="">
                    <img src="<?php echo Lib_Helper::getImage("boton/security.png") ?>" alt="[SERVER INFO]" />
                    <br />
                    <span><?php echo PANEL_PERMISSION; ?></span>
                </a>
            </li>
            <li class="panel-item">
                <a href="">
                    <img src="<?php echo Lib_Helper::getImage("boton/users.png") ?>" alt="[SERVER INFO]" />
                    <br />
                    <span><?php echo PANEL_ACCOUNTS; ?></span>
                </a>
            </li>
            <li class="panel-item">
                <a href="">
                    <img src="<?php echo Lib_Helper::getImage("boton/reports.png") ?>" alt="[SERVER INFO]" />
                    <br />
                    <span><?php echo PANEL_REPORT; ?></span>
                </a>
            </li>
        </ul>
        <?php
    }

}

?>
