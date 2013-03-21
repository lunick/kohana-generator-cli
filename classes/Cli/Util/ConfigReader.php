<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Util_ConfigReader {
    
    public static function get_key($key){
         return self::get_config()->{$key};
    }
    
    public static function get_config(){
         return Kohana::$config->load("generator");
    }
}

?>
