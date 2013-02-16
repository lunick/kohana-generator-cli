<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Util_Kohana {
    
    public static $JS = 1;
    public static $CSS = 2;
    public static $IMG = 3;
    public static $ASSETS = 4;
    public static $CONTROLLER = 5;
    public static $MODEL = 6;
    public static $CONFIG = 7;
    public static $I18n = 8;
    public static $LOGS = 9;
    public static $MESSAGES = 10;
    public static $VIEWS = 11;
    
    
    public static function paths($num){
        switch ($num){
            
            case self::$JS :
                return DOCROOT."assets" . DIRECTORY_SEPARATOR . "js" . DIRECTORY_SEPARATOR;
            break;
            
            case self::$CSS :
                return DOCROOT."assets" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR;
            break;
        
            case self::$IMG :
                return DOCROOT."assets" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
            break;
        
            case self::$ASSETS :
                return DOCROOT."assets" . DIRECTORY_SEPARATOR;
            break;
        
            case self::$CONTROLLER :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . Generator_Util_Text::name("Controller") . DIRECTORY_SEPARATOR;
            break;
            
            case self::$MODEL :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . Generator_Util_Text::name("Model") . DIRECTORY_SEPARATOR;
            break;
        
            case self::$CONFIG :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR;
            break;
        
            case self::$I18n :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "i18n" . DIRECTORY_SEPARATOR;
            break;
        
            case self::$LOGS :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR;
            break;
        
            case self::$MESSAGES :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "messages" . DIRECTORY_SEPARATOR;
            break;
            
            case self::$VIEWS :
                return DOCROOT."application". DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR;
            break;
        
        }
    }
    
    public static function get_hash(){
        return array(
            "js" => self::$JS,
            "css" => self::$CSS,
            "img" => self::$IMG,
            "assets" => self::$ASSETS,
            "controller" => self::$CONTROLLER,
            "model" => self::$MODEL,
            "config" => self::$CONFIG,
            "i18n" => self::$I18n,
            "logs" => self::$LOGS,
            "messages" => self::$MESSAGES,
            "views" => self::$VIEWS,
        );
    }
    
    public static function paths_from_string($key){
        $array = self::get_hash();
        return self::paths($array[$key]);
    }
    
    public static function extension($num){
        switch ($num){
            case self::$JS :
                return "js";
            break;
            
            case self::$CSS :
                return "css";
            break;
                    
            default :
                return "php";
        }
    }
    
    public static function upper_first($num){
        switch ($num){
            case self::$MODEL :
                return true;
            break;
            
            case self::$CONTROLLER :
                return true;
            break;
                    
            default :
                return false;
        }
    }
    
    
    public static function extension_from_string($key){
        $array = self::get_hash();
        return self::extension($array[$key]);
    }

}

?>