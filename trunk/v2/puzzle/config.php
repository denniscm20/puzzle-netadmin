<?php

    // Configurable variables    
    define ("DEFAULT_TITLE", "Puzzle NetAdmin");
    define ("TIMEZONE", "America/Lima");

    define ("DB_NAME", "puzzle_database.sqlite");
    define ("EMAIL_ACCOUNT", "root@localhost.localdomain");
    define ("FRIENDLY_URL", false);
    
    // Directory tree
    define ("ROOT",$_SERVER['DOCUMENT_ROOT']);
    define ("PATH_BASE", ROOT."/Base/");
    define ("PATH_ERROR", PATH_BASE."/Error/");
    define ("PATH_DATABASE", ROOT."/DataBase/");
    define ("PATH_LIB", ROOT."/Lib/");
    define ("PATH_PIECE", ROOT."/Piece/");
    define ("PATH_THEME", "/Theme/");
    define ("PATH_TMP", ROOT."/tmp/");

    define ("PATH_VIEW", PATH_PIECE."%s/View/");
    define ("PATH_JS", "/Piece/%s/View/js/");
    define ("PATH_CONTROLLER", PATH_PIECE."%s/Controller/");
    define ("PATH_MODEL", PATH_PIECE."%s/Model/");
    define ("PATH_CLASS", PATH_MODEL."Class/");
    define ("PATH_DAO", PATH_MODEL."Dao/");
    define ("PATH_TRANSLATION", PATH_PIECE."%s/Translation/");

    define ("PATH_CSS", PATH_THEME."%s/css/");
    define ("PATH_IMAGES", PATH_THEME."%s/images/");

    define ("PATH_BIN", "/home/puzzle/");
    define ("SUDO_COMMAND", "echo %s | sudo /usr/bin/php -f ".PATH_BIN."puzzle.php");
    define ("COMMAND", "echo %s | /usr/bin/php -f ".PATH_BIN."puzzle.php");

    //X-Fixes
    define ("VIEW_SUFFIX", "View");
    define ("CONTROLLER_SUFFIX", "Controller");
    define ("DAO_SUFFIX", "DAO");
    define ("CLASS_SUFFIX", "");
    define ("PIECE_PREFFIX", "%s_%s_");

    // Default values
    define ("DEFAULT_THEME", "default");
    define ("DEFAULT_LANGUAGE", "EN");
    define ("DEFAULT_DATE_FORMAT", "");
    define ("DEFAULT_EVENT", "load");
    define ("DEFAULT_PIECE", "Core");
    define ("DEFAULT_LOGOUT_PAGE", "Login");
    define ("DEFAULT_LOGIN_PAGE", "Panel");

    define ("DEFAULT_TOKEN_LIFETIME", "7");
    define ("DEFAULT_LIST_LIMIT", 10);
    define ("MAX_LIST_LIMIT", 100);
    
?>
