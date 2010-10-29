<?php
/*
 * Core/View/NodeView.php - Copyright 2010 Dennis Cohn Muroy
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
 * Class that implements the application Node View.
 * @package Core
 * @subpackage View
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Core_View_LoginView extends Base_View
{
    // --- ATTRIBUTES ---

    private $node;
    private $serviceList;
    private $subnet;

    // --- OPERATIONS ---

    /**
     * Class Constructor
     *
     * @access public
     * @author Dennis Cohn Muroy
     * @param  Controller controller
     */
    public function __construct($controller)
    {
        parent::__construct($controller, NODE_TITLE);
        $this->node = $this->get("node");
        $this->serviceList = $this->get("serviceList");
        $this->subnet = $this->get("subnet");
    }

    /**
     * Class Destructor.
     *
     * @access public
     * @author Dennis Cohn Muroy
     */
    public function __destruct()
    {
        parent::__destruct();
        unset($this->node);
        unset($this->subnet);
        foreach ($this->serviceList as $service) {
            unset($service);
        }
        unset($this->serviceList);
    }

    /**
     * Displays the page main content.
     *
     * @access public
     * @author Dennis Cohn Muroy
     */
    public function show()
    {
        $url = new Lib_Url(FRIENDLY_URL);
        
        $name = new Lib_Html_Input("name", $this->node->Name, NODE_NAME_LABEL, 1, 'n');
        $description = new Lib_Html_TextArea("description", $this->node->Description, NODE_DESCRIPTION_LABEL, 2, 'd');
        $ipv4 = new Lib_Html_Input("ipv4", $this->node->IPv4, NODE_IPV4_LABEL, 3, '4');
        $ipv6 = new Lib_Html_Input("ipv6", $this->node->IPv6, NODE_IPV6_LABEL, 4, '6');
        $cancelLink = "<a href=\"".$url->build("Core", "Subnet", "load", $this->subnet->Id)."\">".NODE_CANCEL_LINK."</a>";
        $submitButton = new Lib_Html_Button("submit-data", NODE_SAVE_BUTTON, 5);
        ?>
        <fieldset>
            <legend><?php echo NODE_DATA_LEGEND; ?></legend>
            <form action="<?php echo $url->build("Core", "Node","save"); ?>" method="post">
                <div class="row"><?php echo $name->showTextBox(30, ""); ?></div>
                <div class="row"><?php echo $description->showTextArea(3, 10, true, 255, "") ?></div>
                <div class="row"><?php echo $ipv4->showTextBox(15, ""),' / ',$this->subnet->Mask4; ?></div>
                <div class="row"><?php echo $ipv6->showTextBox(40, ""),' / ',$this->subnet->Mask6; ?></div>
                <div class="row right"><?php echo $cancelLink, $submitButton->showSubmitButton(); ?></div>
            </form>
        </fieldset>
        <form action="<?php echo $url->build("Core", "Node", "service"); ?>" method="post">
            <table>
                <thead></thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </form>
        <?php
    }

}

?>
