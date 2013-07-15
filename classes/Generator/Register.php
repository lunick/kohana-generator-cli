<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Generator_Register {
    
    private static $register = array(
        "db:s" => array(
            "class" => "Cli_Generator_Template_Database", 
            "callback" => "Cli_Help::check_dbconnection",
        ),
        "db:t" => array( 
            "callback" => "Cli_Help::check_dbconnection",
        ),
        "db:l" => array(
            "callback" => "Cli_Help::print_dbtables",
        ),
        "c:b" => array(
            "class" => "Cli_Generator_Service_ClearBackup", 
        ),
        "c:c" => array(
            "callback" => "Cli_Help::clear_cache",
        ),
        "c:l" => array(
            "callback" => "Cli_Help::clear_log",
        ),
        "g:c" => array(
            "class" => "Cli_Generator_Template_Controller",
        ),
        
        "g:ct" => array(
            "class" => "Cli_Generator_Template_ControllerTemplate",
        ),
        
        "g:v" => array(
            "class" => "Cli_Generator_Template_View",
        ),
        
        "g:t" => array(
            "class" => "Cli_Generator_Template_Template",
        ),
        
        "g:vl" => array(
            "class" => "Cli_Generator_Template_List",
        ),
        
        "g:vs" => array(
            "class" => "Cli_Generator_Template_Show",
        ),
        
        "g:vf" => array(
            "class" => "Cli_Generator_Template_Form",
        ),
        
        "g:vd" => array(
            "class" => "Cli_Generator_Template_Delete",
        ),
        
        "g:o" => array(
            "class" => "Cli_Generator_Template_Orm",
        ),
        
        "g:m" => array(
            "class" => "Cli_Generator_Template_Model",
        ),
        
        "g:l" => array(
            "class" => "Cli_Generator_Template_I18n",
        ),
        
        "g:cr" => array(
            "class" => "Cli_Generator_Template_Crud",
        ),
        
        "g:b" => array(
            "class" => "Cli_Generator_Service_Backup",
        ),
        
        "g:au" => array(
            "class" => "Cli_Generator_Template_Auth",
        ),
        
        "g:as" => array(
            "class" => "Cli_Generator_Template_Asset",
        ),
        
    );
    
    public static function get_register(){
        return self::$register;
    }
    
    public static function get_class($command){
       if(isset(self::$register[$command]))
       {
           if(isset(self::$register[$command]["class"]))
           {
               return self::$register[$command]["class"];
           }
       }
       return false;
    }
    
    public static function get_callback($command){
       if(isset(self::$register[$command]))
       {
           if(isset(self::$register[$command]["callback"]))
           {
               return self::$register[$command]["callback"];
           }
       }
       return false;
    }
    
    public static function get_callback_params($command){
       if(isset(self::$register[$command]))
       {
           if(isset(self::$register[$command]["callback_params"]))
           {
               return self::$register[$command]["callback_params"];
           }
       }
       return array();
    }
    
    public static function command_exists($command){
        return array_key_exists($command, self::$register);
    }
}

?>
