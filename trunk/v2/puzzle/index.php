<?php
    ob_start();
	require_once ("./config.php");

	$page = DEFAULT_LOGOUT_PAGE;
	$piece = "";
	$event = DEFAULT_EVENT;
	date_default_timezone_set(TIMEZONE);
	
	session_start();
	
	if (isset($_SESSION["User"])) {
        session_regenerate_id();
	    $page = (isset($_GET["Page"]))?$_GET["Page"]:DEFAULT_LOGIN_PAGE;
	    $piece = (isset($_GET["Piece"]))?$_GET["Piece"]:"";
	    $event = (isset($_GET["Event"]))?$_GET["Event"]:"";
	}
	
	if (!isset($_SESSION["Language"])) {
	    $_SESSION["Language"] = DEFAULT_LANGUAGE;
	}
	
	require_once (PATH_BASE."PageBuilder.php");
	$pageBuilder = new PageBuilder ($page, $piece, $event);
	$pageBuilder->show();
	
	ob_end_flush();
?>
