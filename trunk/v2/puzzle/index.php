<?php
    ob_start();
    require_once ("./config.php");
    require_once (PATH_BASE."PageBuilder.php");
    require_once PATH_LIB.'Url.php';

    date_default_timezone_set(TIMEZONE);
    $is_ajax = false;
    
    session_start();

    $url = new Lib_Url(FRIENDLY_URL);
    $url->fill();
    if (isset($_SESSION["User"])) {
        /** 
         * @todo : session_regenerate_id(true) on login/logout, and when 
         * interacting with administrative privileges 
         */
    } else {
        $url->build(DEFAULT_PIECE, DEFAULT_LOGOUT_PAGE, $url->getEvent());
    }

    if (!isset($_SESSION["Language"])) {
        $_SESSION["Language"] = DEFAULT_LANGUAGE;
    }

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $is_ajax = true;
    }

    $pageBuilder = new PageBuilder ($url);
    $pageBuilder->show($is_ajax);

    ob_end_flush();
?>
