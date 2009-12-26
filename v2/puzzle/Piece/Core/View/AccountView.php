<?php
/*
 * Core/View/AccountView.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the application Account View.
 * @package Core
 * @subpackage View
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_View_AccountView extends Base_View
{
    // --- ATTRIBUTES ---
    private $user = null;

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
        parent::__construct($controller, "");
        $this->user = $this->controller->get("user");
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
        $userName = new Lib_Html_Input("username", "", "", 1, 'u');
        $password = new Lib_Html_Input("password", "", "", 2, 'p');
        $validatePassword = new Lib_Html_Input("validatePassword", "", "", 3, 'v');
        $enabled = new Lib_Html_Input("enabled", $this->user->Enabled, "", 4, 'e');
        $submitButton = new Lib_Html_Button("submit", LOGIN_SUBMIT_BUTTON, 5);
        ?>
        <div class="">
            <form action="/?Page=Account&amp;Event=save" method="post">
                <div class="row"><?php echo $userName->showTextBox(40, "", "login"); ?></div>
                <div class="row"><?php echo $password->showPassword(40, "", "login"); ?></div>
                <div class="row"><?php echo $enabled->showCheckBox("enabled", $this->user->Enabled); ?></div>
                <div class="row right"><?php echo $submitButton->showSubmitButton(); ?></div>
            </form>
        </div>
        <?php
    }

}

?>
