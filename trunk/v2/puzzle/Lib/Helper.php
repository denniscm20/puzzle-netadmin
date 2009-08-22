<?php

/*
 * Base/Helper.php - Copyright 2009 Dennis Cohn Muroy
 *
 * This file is part of puzzle.
 *
 * tiny-weblog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * tiny-weblog is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with puzzle.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @package /Lib/
 * @class Helper
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
 
class Helper {
    
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

    
    public static function maskToShortMask ($pMascara) {
        $lValues = explode(".",$pMascara);
        $lCount = count($lValues);

        if ($lCount != 4) {
            return false;
        }
        
        $lMaskNumber = 0;
        $lZeroValue = false;
        
        for ($i = 0; $i < $lCount; $i++) {
            $lValue = $lValues[$i];
            $lMask = 0x1;
            for ($j = 0; $j < 8; $j++) {
                $lBit = ($lValue >> (7 - $j)) & $lMask;
                if ($lBit) {
                    $lMaskNumber++;
                } else {
                    $lZeroValue = true;
                    break;
                }
            }
            if ($lZeroValue) {
                break;
            }
        }
        return $lMaskNumber;
    }
    
    public static function cambiarFormatoFecha($pFecha, $pFormatoFinal) {
        return date($pFormatoFinal,strtotime($pFecha));
    }

    public static function getRemoteIP ()
    {
        $ipReals = isset($_SERVER['HTTP_X_FORWARDED_FOR'])? $_SERVER['HTTP_X_FORWARDED_FOR'] : "";
        foreach (explode(",",$ipReals) as $ip) {
            return $ip;
        }
        $ip = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : "";
        return $ip;
    }

    public static function getImage($img)
    {
        $theme = $_SESSION['Theme'];
        $imagePath = sprintf(IMG_PATH, $theme);
        $imagePath .= $img;
        return $imagePath;
    }

}

?>