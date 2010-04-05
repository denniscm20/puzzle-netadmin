<?php
/*
 * Base/Audit.php - Copyright 2010 Dennis Cohn Muroy
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
 * Application Base Class which contains the common attributes for auditing.
 * @abstract
 * @author Dennis Cohn Muroy
 * @package Base
 * @since 2010
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Base_Audit extends Base_Class
{
    /**
     * @var String
     */
    private $createdDate;

    /**
     * @var Core_Model_Class_Account
     */
    private $accountCreator;

    /**
     * @var String
     */
    private $modifiedDate;

    /**
     * @var Core_Model_Class_Account
     */
    private $accountModifier;

    /**
     * @var String
     */
    private $lastApplyDate;

    /**
     * @var Core_Model_Class_Account
     */
    private $accountApply;

    protected function __construct()
    {
        parent::__construct();
        $classAccount = Lib_Helper::getClass("Core", "Account");
        $this->createdDate = $this->modifiedDate = date(DEFAULT_DATE_FORMAT);
        $this->lastApplyDate = "";
        $this->accountCreator = new $classAccount();
        $this->accountModifier = new $classAccount();
        $this->accountApply = new $classAccount();
    }

    protected function __destruct()
    {
        parent::__destruct();
        unset($this->accountCreator);
        unset($this->accountModifier);
        unset($this->accountApply);
    }

    public function getCreatedDate() {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;
    }

    public function getAccountCreator() {
        return $this->accountCreator;
    }

    public function setAccountCreator($accountCreator) {
        $this->accountCreator = $accountCreator;
    }

    public function getModifiedDate() {
        return $this->modifiedDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    public function getAccountModifier() {
        return $this->accountModifier;
    }

    public function setAccountModifier($accountModifier) {
        $this->accountModifier = $accountModifier;
    }

    public function getLastApplyDate() {
        return $this->lastApplyDate;
    }

    public function setLastApplyDate($lastApplyDate) {
        $this->lastApplyDate = $lastApplyDate;
    }

    public function getAccountApply() {
        return $this->accountApply;
    }

    public function setAccountApply($accountApply) {
        $this->accountApply = $accountApply;
    }
}
?>
