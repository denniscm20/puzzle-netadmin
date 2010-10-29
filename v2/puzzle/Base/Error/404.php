<?php
    header("HTTP/1.0 404 Not Found");
    $picture = Lib_Helper::getImage("error/404.png");
    $message = ERROR_404_MESSAGE;
    $link = "";
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo DEFAULT_TITLE," - ",ERROR_404_TITLE; ?> </title>
    </head>
    <body style="background-color:black; width: 600px; margin-left:auto; margin-right:auto; margin-top:20px;">
        <div style="border: double white thin; background-color: red; height: 100px;">
            <span style="float: left; margin: 25px;">
                <img alt="[Error 404]" src="<?php echo $picture; ?>" />
            </span>
            <span style="float: left; color: white; font-weight: bold; margin-top: 30px;">
                <?php echo $message; ?>
            </span>
        </div>
        <div>
            <a href = "/"><?php echo $link; ?></a>
        </div>
    </body>
</html>
