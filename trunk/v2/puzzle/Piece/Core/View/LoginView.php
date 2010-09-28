<?php
/*
 * Core/View/LoginView.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the application Login View.
 * @package Core
 * @subpackage View
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_View_LoginView extends Base_View
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
        $url = new Lib_Url(FRIENDLY_URL);
        $url = $url->build("Core", "Login","login");
        $userName = new Lib_Html_Input("username", "", LOGIN_USER_FIELD, 1, 'u');
        $password = new Lib_Html_Input("password", "", LOGIN_PASSWORD_FIELD, 2, 'p');
        $submitButton = new Lib_Html_Button("submit", LOGIN_SUBMIT_BUTTON, 3);
        $resetButton = new Lib_Html_Button("reset", LOGIN_RESET_BUTTON, 4);
        ?>
        <div class="loginintro">
            <?php echo LOREM_IPSUM; ?>
        </div>
        <div class="loginform">
            <form action="<?php echo $url; ?>" method="post">
                <div class="row"><?php echo $userName->showTextBox(40, "", "login"); ?></div>
                <div class="row"><?php echo $password->showPassword(40, "", "login"); ?></div>
                <div class="row right"><?php echo $resetButton->showResetButton(), $submitButton->showSubmitButton(); ?></div>
            </form>
        </div>
        <?php
    }

}

?>
