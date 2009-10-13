<?php

/*
 * Lib/Helper.php - Copyright 2009 Dennis Cohn Muroy
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

/**
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 * @since 2009
 * @package Lib
 * @copyright Copyright (c) 2009, Dennis Cohn
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Lib_Helper {
    
    /**
     * This method verifies if a PHP module has been installed.
     * @param mixed $module This parameter can be a string or it can be an
     * array of strings; each of those strings represents the name of the
     * module the user wants to know if it has been installed.
     * @return bool True if the module or all the modules has been installed.
     */
    public static function isModuleInstalled ( $module ) {
        $installedModules = apache_get_modules();
        $count = 0;
        if (!is_array($module)) {
            $module = array($module);
            $count = 1;
        } else
            $count = count($module);
        for ($i = 0; $i < $count; $i++ )
            if (array_search( $module[$i], $installedModules ) === FALSE)
                return FALSE;
        return TRUE;
    }

    public static function getView ($pieceName, $fileName)
    {
        $file = sprintf(PATH_VIEW, $pieceName);
        $file .= $fileName.VIEW_SUFFIX.".php";
        if (file_exists($file)) {
            require_once($file);
            $class = sprintf(PIECE_PREFFIX, ucfirst($pieceName),"View");
            $class .= $fileName.VIEW_SUFFIX;
            return $class;
        }
        return false;
    }

    public static function getController ($pieceName, $fileName)
    {
        $file = sprintf(PATH_CONTROLLER, $pieceName);
        $file .= $fileName.CONTROLLER_SUFFIX.".php";
        if (file_exists($file)) {
            require_once($file);
            $class = sprintf(PIECE_PREFFIX, ucfirst($pieceName),"Controller");
            $class .= $fileName.CONTROLLER_SUFFIX;
            return $class;
        }
        return false;
    }

    public static function getClass ($pieceName, $fileName)
    {
        $file = sprintf(PATH_CLASS, $pieceName);
        $file .= $fileName.CLASS_SUFFIX.".php";
        if (file_exists($file)) {
            require_once($file);
            $class = sprintf(PIECE_PREFFIX, $pieceName,"Model_Class");
            $class .= $fileName.CLASS_SUFFIX;
            return $class;
        }
        return false;
    }

    public static function getDao ($pieceName, $fileName)
    {
        $file = sprintf(PATH_DAO, $pieceName);
        $file .= $fileName.DAO_SUFFIX.".php";
        if (file_exists($file)) {
            require_once($file);
            $class = sprintf(PIECE_PREFFIX, $pieceName,"Model_Dao");
            $class .= $fileName.DAO_SUFFIX;
            return $class;
        }
        return false;
    }

    public static function getTranslation ($pieceName, $language)
    {
        $file = sprintf(PATH_TRANSLATION, $pieceName);
        $file .= $language.".php";
        if (file_exists($file)) {
            require_once($file);
            return $language;
        }
        return false;
    }

    public static function redirect ($pieceName, $pageName)
    {
        $url = "/index.php?Piece=".$pieceName."&Page=".$pageName;
        header ("Location: ".$url);
        exit;
    }

    public static function changeDateFormat($date, $newFormat)
    {
        return date($newFormat,strtotime($date));
    }

    public static function getImage($img)
    {
        $imagePath = sprintf(PATH_IMAGES, DEFAULT_THEME);
        $imagePath .= $img;
        return $imagePath;
    }

    public static function getRemoteIP ()
    {
        $ipReals = isset($_SERVER['HTTP_X_FORWARDED_FOR'])? $_SERVER['HTTP_X_FORWARDED_FOR'] : "";
        if ($ipReals != "") {
            $ipReals = explode(",",$ipReals);
            if (count($ipReals) > 0) {
                return $ipReals[0];
            }
        }
        $ip = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : "";
        return $ip;
    }

}

?>