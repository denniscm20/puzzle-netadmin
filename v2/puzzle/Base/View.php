<?php
/*
 * Base/View.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_LIB.'MessageHandler.php';

/**
 * Abstract class that implements the basic methods of the view class.
 * @abstract
 * @package Base
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Base_View
{
    // --- ASSOCIATIONS ---
    protected $controller;

    // --- ATTRIBUTES ---

    protected $title = "";
    protected $javascript = array();
    protected $css = array();
    
    // --- OPERATIONS ---

    /**
     * Class Constructor
     *
     * @access protected
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @param  Controller controller Page controller
     * @param  String title Page title
     * @return void
     */
    protected function __construct($controller, $title = DEFAULT_TITLE)
    {
        $this->controller = $controller;
        $this->title = $title;
        $this->javascript = array();
        $this->css = array();
    }

    /**
     * Class Destructor.
     *
     * @access protected
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return void
     */
    protected function __destruct()
    {
        unset($this->controller);
    }

    /**
     * Returns the title of the displayed page.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Returns the javascript file names of the displayed page.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return array
     */
    public function getJavascript()
    {
        return $this->javascript;
    }
    
    /**
     * Returns the css file names of the displayed page.
     *
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return array
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Displays the page main content.
     *
     * @abstract
     * @access public
     * @author Dennis Cohn Muroy, <dennis.cohn@pucp.edu.pe>
     * @return void
     */
    public abstract function show();

}

?>