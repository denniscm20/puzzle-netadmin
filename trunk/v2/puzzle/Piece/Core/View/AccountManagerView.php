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
require_once PATH_LIB.'Html/AdvanceTable.php';

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
class Core_View_AccountManagerView extends Base_View
{
    // --- ATTRIBUTES ---
    private $accountList = array();
    private $statusList = array();
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
        parent::__construct($controller, ACCOUNT_MANAGER_TITLE);
        $this->accountList = $this->get("accountList");
        $this->user = $this->get("user");
        $this->statusList = $this->get("statusList");
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
        foreach ($this->accountList as $account) {
            unset ($account);
        }
        unset($this->accountList);
        unset($this->user);
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
        $hiddenEvent = new Lib_Html_Input("event", "", "");
        $hiddenId = new Lib_Html_Input("id", "", "");
        $hiddenUser = new Lib_Html_Input("username-search", "", "");
        $hiddenEnable = new Lib_Html_Input("status-search", "", "");
    ?>
        <form id="form" action="<?php echo $url->build("Core", "AccountManager"); ?>" method="POST">
    <?php
        echo $hiddenId->showHidden();
        echo $hiddenEvent->showHidden();
        echo $hiddenUser->showHidden();
        echo $hiddenEnable->showHidden();
        $this->showToolbar();
        $this->showTable();
    ?>
        </form>
    <?php
    }

    public function showToolbar()
    {
        $user = new Lib_Html_Input("username", ACCOUNT_MANAGER_USER_LABEL, ACCOUNT_MANAGER_USER_LABEL, 1, "u");
        $user->onFocus("evtTextFocus('username','".ACCOUNT_MANAGER_USER_LABEL."')");
        $user->onBlur("evtTextBlur('username','".ACCOUNT_MANAGER_USER_LABEL."')");
        $status = new Lib_Html_Select("status", $this->statusList, ACCOUNT_MANAGER_STATUS_LABEL, "", "", 2, "s");
        $search = new Lib_Html_Button("search", "", Lib_Html_Button::TYPE_GENERAL, 3, "search-button");
        $search->onClick("evtSearch('form');");
        ?>
        <div id="toolbar">
            <?php echo $user->showTextBox(50, "", ""), $status->showComboBox(-1, "", ""), $search->show(); ?>
        </div>
        <?php
    }

    public function showTable()
    {
        $url = new Lib_Url(FRIENDLY_URL);
        $add = new Lib_Html_Button("add", "", Lib_Html_Button::TYPE_GENERAL, 4, "add-button");
        $add->onClick("");
        $delete = new Lib_Html_Button("delete", "", Lib_Html_Button::TYPE_GENERAL, 5, "delete-button");
        $delete->onClick("evtDelete('form');");
        $table = new Lib_Html_AdvanceTable("user", $url->build("Core", "Account", "load", array("id"=>"%s")));
        $header = array(ACCOUNT_MANAGER_USER_LABEL => "Username",
            ACCOUNT_MANAGER_ROLE_LABEL => "Role",
            ACCOUNT_MANAGER_STATUS_LABEL => "Enabled",
            ACCOUNT_MANAGER_ACCESS_LABEL => "LastLogin");
        $format =  array(ACCOUNT_MANAGER_USER_LABEL => Lib_Html_AdvanceTable::TYPE_MIXED,
            ACCOUNT_MANAGER_ROLE_LABEL => Lib_Html_AdvanceTable::TYPE_MIXED,
            ACCOUNT_MANAGER_STATUS_LABEL => Lib_Html_AdvanceTable::TYPE_BOOL,
            ACCOUNT_MANAGER_ACCESS_LABEL  => Lib_Html_AdvanceTable::TYPE_TIMESTAMP);
        $footer = array(ACCOUNT_MANAGER_NEW_LABEL, $add->show(),
            ACCOUNT_MANAGER_DELETE_LABEL,$delete->show());
        $table->setHeader($header, ACCOUNT_MANAGER_USER_LABEL, $format);
        $table->setFooter($footer);
        foreach($this->accountList as $account) {
            $table->addRow($account);
        }
        echo $table->show();
    }

}

?>
