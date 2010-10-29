<?php
    header("HTTP/1.0 403 Forbidden");
    $picture = Lib_Helper::getImage("error/403.png");
    $message = ERROR_403_MESSAGE;
    $link = "";
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo DEFAULT_TITLE," - ",ERROR_403_TITLE; ?> </title>
    </head>
    <body style="background-color:black; width: 600px; margin-left:auto; margin-right:auto; margin-top:20px;">
        <div style="border: double white thin; background-color: red; height: 100px;">
            <span style="float: left; margin: 30px;">
                <img alt="[Error 403]" src="<?php echo $picture; ?>" />
            </span>
            <span style="float: left; color: white; font-weight: bold; margin-top: 45px;">
                <?php echo $message;?>
            </span>
        </div>
        <div>
            <a href = "/"><?php echo $link; ?></a>
        </div>
    </body>
</html>
