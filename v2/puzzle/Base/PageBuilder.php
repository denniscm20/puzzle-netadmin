<?php
/*
 * Base/PageBuilder.php - Copyright 2009 Dennis Cohn Muroy
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

require_once PATH_LIB.'Helper.php';
require_once PATH_LIB.'MessageHandler.php';

/**
 * This class contains the methods for building the page structure.
 * @package Base
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class PageBuilder
{
    private $view;
    private $controller;
    private $piece;
    private $page;
    private $language;
    
    public function  __construct($page, $piece, $event) {
        $this->page = $page;
        $this->piece = $piece;
        $this->language = $_SESSION["Language"];
        $this->language = Lib_Helper::getTranslation($piece, $this->language);
        $viewClass = Lib_Helper::getView($piece, $page);
        $controllerClass = Lib_Helper::getController($piece, $page);
        if (($viewClass !== false) && ($controllerClass !== false)) {
            eval("\$this->controller = ".$controllerClass."::getInstance('".$this->piece."', '".$this->page."');");
            $this->controller->execute ($event);
            $this->view = new $viewClass($this->controller);
        } else {
	        header("HTTP/1.0 404 Not Found");
	        exit();
	    }
    }

    private function printAditionalCss ($template)
    {
        $cssList = $this->view->getCss();
        foreach ($cssList as $css) {
        ?>
            <link rel="stylesheet" type="text/css" href="<?php echo sprintf(PATH_CSS, $template),$css; ?>" />
        <?php
        }
    }
    
    private function printAditionalJavascript ($template) 
    {
        $jsList = $this->view->getJavascript();
        foreach ($jsList as $js) {
        ?>
            <script type="text/javascript" src="<?php echo sprintf(PATH_JS, $this->piece),$js; ?>" />
        <?php
        }
    }

    public function show()
    {
        echo '<?xml version="1.0" encoding="utf-8"?>';
        $template = DEFAULT_THEME;
    ?>
           
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//<?php echo $this->language; ?>" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->language; ?>">
        <head>
            <title><?php echo DEFAULT_TITLE," - ",$this->view->getTitle(); ?></title>
            <meta name="AUTHOR" content="Dennis Cohn Muroy" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <link rel="stylesheet" type="text/css" href="<?php echo sprintf(PATH_CSS, $template); ?>style.css" />
            <?php $this->printAditionalCss($template) ?>
            <script type="text/javascript" src="<?php echo sprintf(PATH_JS, DEFAULT_PIECE); ?>jquery.js" ></script>
            <script type="text/javascript" src="<?php echo sprintf(PATH_JS, DEFAULT_PIECE); ?>events.js" ></script>
            <script type="text/javascript" src="<?php echo sprintf(PATH_JS, DEFAULT_PIECE); ?>cypher.js" ></script>
            <?php $this->printAditionalJavascript($template) ?>
        </head>
        <body>
            <div>
                <?php if ($this->page == DEFAULT_LOGOUT_PAGE) { ?>
                <div id="banner_out" style="background-image:url(<?php echo "'",Lib_Helper::getImage('header_back.jpg'),"'";?>)">
                    <img src="<?php echo Lib_Helper::getImage('logo.png'); ?>" alt="Logo" />
                    <img src="<?php echo Lib_Helper::getImage('title.png'); ?>" alt="Puzzle" />
                </div>
                <?php } else { ?>
                <div id="banner_in" style="background-image:url(<?php echo "'",Helper::getImage('header_back.jpg'),"'";?>)">
                    <img class="banner_image" src="<?php echo Lib_Helper::getImage('logo.png'); ?>" alt="Logo" />
                    <img class="banner_image" src="<?php echo Lib_Helper::getImage('title.png'); ?>" alt="Puzzle" />
                    <ul class="actions">
                        <li>
                            <a href="/?Page=<?php echo DEFAULT_LOGOUT_PAGE ?>&amp;Event=logout">
                                <?php echo LOG_OUT;?>
                            </a>
                        </li>
                    </ul>
                    <ul class="sections">
                        <li>Item 1</li>
                        <li>Item 2</li>
                        <li>Item 3</li>
                        <li>Item 4</li>
                    </ul>
                </div>
                <?php } ?>
                <div id="content">
                    <div id="message">
                    <?php
                        $messageHandler = Lib_MessagesHandler::getInstance();
                        $messageHandler->showMessages();
                    ?>
                    </div>
                    <br />
                    <?php $this->view->show(); ?>
                </div>
            </div>
            <div id="footer" style="background-image:url(<?php echo "'",Lib_Helper::getImage('footer_back.jpg'),"'";?>)">
                <div>&copy; Dennis Stephen Cohn Muroy</div>
            </div>
        </body>
        </html>
    <?php
    }
}

?>
