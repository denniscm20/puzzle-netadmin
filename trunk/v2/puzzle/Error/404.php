<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    require_once PATH_LIB.'Helper.php';
    if (isset($_SESSION['User'])) {
        Lib_Helper::redirect("Core", "NotFound");
    }
    Lib_Helper::getTranslation("Core", DEFAULT_LANGUAGE);
    $template = DEFAULT_THEME;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo DEFAULT_TITLE," - ",ERROR_404_TITLE; ?> </title>
    </head>
    <body style="background-color:black; width: 600px; margin-left:auto; margin-right:auto; margin-top:20px;">
        <div style="border: double white thin; background-color: red; height: 100px;">
            <span style="float: left; margin: 25px;">
                <img alt="[Error 404]" src="<?php echo Lib_Helper::getImage("error/404.png") ?>" />
            </span>
            <span style="float: left; color: white; font-weight: bold; margin-top: 30px;">
                <?php echo ERROR_404_MESSAGE;?>
            </span>
        </div>
    </body>
</html>
