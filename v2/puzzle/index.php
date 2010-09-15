<?php
    ob_start();
    require_once ("./config.php");
    require_once (PATH_BASE."PageBuilder.php");

    date_default_timezone_set(TIMEZONE);
    $page = DEFAULT_LOGOUT_PAGE;
    $piece = DEFAULT_PIECE;
    $event = DEFAULT_EVENT;
    $identifier = null;
    $is_ajax = false;
    
    session_start();

    if (isset($_SESSION["User"])) {
        /** @todo : session_regenerate_id(); */
        require_once PATH_LIB.'Url.php';
        $url = new Lib_Url(FRIENDLY_URL);
        $url->fill();
        $piece = $url->getPiece();
        $page = $url->getPage();
        $event = $url->getEvent();
        $identifier = $url->getIdentifier();
        if ($page === null || $piece === null) {
            header("HTTP/1.0 404 Not Found");
            exit();
        }
    }

    if (!isset($_SESSION["Language"])) {
        $_SESSION["Language"] = DEFAULT_LANGUAGE;
    }

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $is_ajax = true;
    }

    $pageBuilder = new PageBuilder ($page, $piece, $event, $identifier);
    $pageBuilder->show($is_ajax);

    ob_end_flush();
?>
