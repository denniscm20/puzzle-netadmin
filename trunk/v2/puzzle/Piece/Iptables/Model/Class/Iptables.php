<?php
/*
 * Iptables/Model/Class/Iptables.php - Copyright 2010 Dennis Cohn Muroy
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

require_once PATH_BASE.'Audit.php';
require_once PATH_LIB.'Command.php';

/**
 * Class that implements the core of the iptables piece.
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2010
 * @package Iptables
 * @subpackage Model
 * @copyright Copyright (c) 2010, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Iptables_Model_Class_Iptables extends Base_Audit
{
    /**
     * @var String
     */
    protected $description;

    /**
     * @var String
     */
    protected $logfile;

    /**
     * @var Boolean
     */
    protected $enable;

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getLogfile() {
        return $this->logfile;
    }

    public function setLogfile($logfile) {
        $this->logfile = $logfile;
    }

    public function getEnable() {
        return $this->enable;
    }

    public function setEnable($enable) {
        $this->enable = $enable;
    }

    public function applyConfiguration()
    {
        $filename = PATH_TMP."iptables_tmp_".$this->getId();
        $this->createFile($filename);
        $this->deleteFile($filename);
        $this->executeCommand($filename);
    }

    private function createFile($filename)
    {
        /**
         * @todo Implement function createFile. Creates $filename File.
         */
    }

    private function deleteFile($filename)
    {
        unlink($filename);
    }

    private function executeCommand($filename)
    {
        $command = "sudo cat ".$filename." | sudo iptables-restore";
        $command = new Lib_Command($command);
        $command->execute();
    }

}
?>
