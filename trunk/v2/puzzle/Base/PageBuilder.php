<?php
/*
 * Base/PageBuilder.php - Copyright 2009 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * tiny-weblog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * tiny-weblog is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with puzzle.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once PATH_LIB.'Helper.php';

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
    
    public function  __construct($page, $piece, $event) {
        $this->page = $page;
        $this->piece = $piece;
        $viewClass = Helper::getView($piece, $page);
        $controllerClass = Helper::getController($piece, $page);
        if (($viewClass !== false) && ($controllerClass !== false)) {
            eval('$this->controller = '.$controllerClass.'::getInstance();');
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
        $template = $this->view->getTheme();
        $language = $_SESSION["Language"];
        $languageFile = TRANSLATION_PATH.$language.'.php';
        require_once($languageFile);
    ?>
        <?php echo '<?xml version="1.0" encoding="utf-8"?>','\n'; ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//<?php echo $language; ?>" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $language; ?>">
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
                <div id="banner" style="background-image:url(<?php echo "'",sprintf(PATH_IMAGES,$template),"header_back.jpg'";?>)">
                    
                </div>
                <?php } else { ?>
                <div id="nav">
                    <ul>
                        <li></li>
                        <li>
                            <a href="/?Page=<?php echo DEFAULT_LOGOUT_PAGE ?>&amp;Event=logout">
                                <?php echo LOG_OUT;?>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php } ?>
                <div>
                    <?php $this->view->show(); ?>
                </div>
            </div>
            <div id="footer" style="background-image:url(<?php echo "'",sprintf(PATH_IMAGES,$template),"footer_back.jpg'";?>)">
                <div>&copy; Dennis Stephen Cohn Muroy</div>
            </div>
        </body>
        </html>
    <?php
    }
}

?>
