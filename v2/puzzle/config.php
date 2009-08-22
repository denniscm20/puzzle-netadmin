<?php

    // Configurable variables    
    define ("DEFAULT_TITLE", "Nombre del Proyecto");
    define ("TIMEZONE", "America/Lima");

    define ("DB_TYPE", "");
    define ("DB_HOST", "");
    define ("DB_NAME", "");
    define ("DB_PORT", "");
    define ("DB_USER", "");
    define ("DB_PASSWORD", "");
    
    // Directory tree
    define ("ROOT",$_SERVER['DOCUMENT_ROOT']);
    define ("PATH_BASE", ROOT."/Base/");
    define ("PATH_DATABASE", ROOT."/DataBase/");
    define ("PATH_LIB", ROOT."/Lib/");
    define ("PATH_PIECE", ROOT."/Piece/");
    define ("PATH_THEME", ROOT."/Theme/");
    define ("PATH_TRANSLATION", ROOT."/Translation/");
    define ("PATH_TMP", ROOT."/tmp/");

    define ("PATH_VIEW", PATH_PIECE."%s/View/");
    define ("PATH_JS", PATH_VIEW."js/");
    define ("PATH_CONTROLLER", PATH_PIECE."%s/Controller/");
    define ("PATH_MODEL", PATH_PIECE."%s/Model/");
    define ("PATH_CLASS", PATH_MODEL."Class/");
    define ("PATH_DAO", PATH_MODEL."Dao/");

    define ("PATH_CSS", PATH_THEME."%s/css/");
    define ("PATH_IMAGES", PATH_THEME."%s/images/");

    //X-Fixes
    define ("VIEW_SUFFIX", "View");
    define ("CONTROLLER_SUFFIX", "Controller");
    define ("DAO_SUFFIX", "DAO");
    define ("CLASS_SUFFIX", "");
    define ("PIECE_PREFFIX", "Piece_%s_%s_");

    // Default values
    define ("DEFAULT_THEME", "default");
    define ("DEFAULT_LANGUAGE", "EN");
    define ("DEFAULT_EVENT", "load");
    define ("DEFAULT_PIECE", "Core");
    define ("DEFAULT_LOGOUT_PAGE", "Login");
    define ("DEFAULT_LOGIN_PAGE", "Panel");
    
?>
