<?php
/*
 * Core/View/ServerView.php - Copyright 2009 Dennis Cohn Muroy
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
 * Class that implements the application Server View.
 * @package Core
 * @subpackage View
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class ServerView extends Base_View
{
    private $server;

    public function  __construct($controller)
    {
        parent::__construct($controller, "");
        $this->server = $this->cotroller->get("server");
    }
    
    public function  __destruct() 
    {
        parent::__destruct();
        unset($this->server);
    }

    public function showData()
    {
        $memory = intval(($this->server->Memory[0] - $this->server->Memory[1])/$this->server->Memory[0])*100;
        $diskList = $this->server->Disk;
        ?>
        <fieldset id="data">
            <legend><?php echo SERVER_DATA_LEGEND; ?></legend>
            <ul>
                <li>
                    <span><?php echo SERVER_HOSTNAME_LABEL; ?></span>
                    <?php echo $this->server->Hostname; ?>
                </li>
                <li>
                    <span><?php echo SERVER_LOAD_LABEL; ?></span>
                    <?php echo implode(" ", $this->server->Load); ?>
                </li>
                <li>
                    <span><?php echo SERVER_DISK_LABEL; ?></span>
                    <?php
                        foreach ($diskList as $label => $size) {
                            $total = intval($size[0]/1024);
                            $ussage = intval($size[1]/1024);
                            $ussagePct = intval($size[1]/$size[0]) * 100;
                            echo $label;
                            ?>
                            <div class="total"><span class="used" title="<?php echo $ussage;?>" style="width: <?php echo $ussagePct;?>%"></span></div>
                            <?php
                            echo $total," G";
                        }
                    ?>
                </li>
                <li>
                    <span><?php echo SERVER_MEMORY_LABEL; ?></span>
                    <div class="total"><span class="used" title="<?php echo $memory;?>%" style="width: <?php echo $memory;?>%"></span></div>
                    <?php echo $this->server->Memory[0]; ?>
                </li>
            </ul>
        </fieldset>
        <?php
    }

    public function showNetwork()
    {
        $image;
        $alt;
        ?>
        <fieldset id="network">
            <legend><?php echo SERVER_NETWORK_LEGEND; ?></legend>
            <ul>
                <li>
                    <span><?php echo SERVER_ROUTE_LABEL; ?></span>
                    <img src="<?php echo $image;?>" alt="<?php echo $alt; ?>" />
                    <?php echo implode(", ", $this->server->DnsList); ?>
                </li>
                <li>
                    <span><?php echo SERVER_DNS_LABEL; ?></span>
                    <?php echo implode(", ", $this->server->DnsList); ?>
                </li>
            </ul>
        </fieldset>
        <?php
    }

    public function showSummary()
    {
        ?>
        <fieldset id="summary">
            <legend><?php echo SERVER_SUMMARY_LEGEND; ?></legend>
            <ul>
                <li><?php echo SERVER_PIECE_LABEL; ?></li>
                <li><?php echo SERVER_SECURITY_LABEL; ?></li>
            </ul>
        </fieldset>
        <?php
    }

    public function show()
    {
        $this->showData();
        $this->showNetwork();
        $this->showSummary();
    }
}
?>
