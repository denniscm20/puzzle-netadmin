<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    require_once PATH_LIB.'Helper.php';
    if (isset($_SESSION['User'])) {
        Lib_Helper::redirect("Core", "NotFound");
    }
    Lib_Helper::getTranslation("Core", DEFAULT_LANGUAGE);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo DEFAULT_TITLE," - ",ERROR_404_TITLE; ?> </title>
    </head>
    <body>
        <?php
            echo ERROR_404_MESSAGE;
        ?>
    </body>
</html>
