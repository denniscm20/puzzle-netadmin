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
    
    public function  __construct($url)
    {
        $this->page = $url->getPage();
        $this->piece = $url->getPiece();
        $this->language = Lib_Helper::getTranslation($this->piece, $_SESSION["Language"]);
        $viewClass = Lib_Helper::getView($this->piece, $this->page);
        $controllerClass = Lib_Helper::getController($this->piece, $this->page);
        if (($viewClass !== false) && ($controllerClass !== false)) {
            $function = array($controllerClass, 'getInstance');
            $this->controller = call_user_func($function);
            $this->controller->execute ($url);
            $this->view = new $viewClass($this->controller);
        } else {
            include(PATH_ERROR."404.php");
            exit();
        }
    }

    private function printAditionalCss ($template)
    {
        $cssList = $this->view->getCss();
        foreach ($cssList as $css) {
        ?><link rel="stylesheet" type="text/css" href="<?php echo sprintf(PATH_CSS, $template),$css; ?>" />
        <?php
        }
    }
    
    private function printAditionalJavascript ($template) 
    {
        $jsList = $this->view->getJavascript();
        foreach ($jsList as $js) {
        ?><script type="text/javascript" src="<?php echo sprintf(PATH_JS, $this->piece),$js; ?>"></script>
        <?php
        }
    }

    public function show($is_ajax = false)
    {
        if ($is_ajax === false) {
            $template = DEFAULT_THEME;
    ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title><?php echo DEFAULT_TITLE," - ",$this->view->getTitle(); ?></title>
                <meta name="AUTHOR" content="Dennis Cohn Muroy" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <link rel="stylesheet" type="text/css" href="<?php echo sprintf(PATH_CSS, $template); ?>style.css" />
                <?php $this->printAditionalCss($template) ?>
                <script type="text/javascript" src="<?php echo sprintf(PATH_JS, DEFAULT_PIECE); ?>jquery.js" ></script>
                <script type="text/javascript" src="<?php echo sprintf(PATH_JS, DEFAULT_PIECE); ?>events.js" ></script>
                <?php $this->printAditionalJavascript($template) ?>
                
            </head>
            <body>
                <div>
                    <div id="header" style="background-image:url(<?php echo "'",Lib_Helper::getImage('header_back.jpg'),"'";?>)">
                        <img id="img-title" src="<?php echo Lib_Helper::getImage('title.png'); ?>" alt="Puzzle" />
                    </div>
                    <?php if (isset($_SESSION["User"])) { ?>
                        <div id="breadcrumb-area">
                            <span id="breadcrumb"><?php $this->view->showBreadcrumb(); ?></span>
                            <span id="logout">
                                <a href="/?Page=<?php echo DEFAULT_LOGOUT_PAGE ?>&amp;Event=logout">
                                <?php echo LOG_OUT;?>
                            </a>
                            </span>
                        </div>
                    <?php } ?>

                    <div id="content">
                        <div id="message"><?php
                            $messageHandler = Lib_MessagesHandler::getInstance();
                            $messageHandler->showMessages();
                        ?></div>
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
        } else {
            $this->view->show();
        }
    }
}

?>
