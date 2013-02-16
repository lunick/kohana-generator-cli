<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Util_Text {
    
    public static function upper_first($string)
    {
        return ucfirst(strtolower($string));
    }
    
    public static function class_name($string){
        $return_string = "";
        $strings = explode("_", $string);
        $count = count($strings); 
        for($i = 0; $i < $count; ++$i){
            if(0 < $i)
            {
                $return_string .= "_".self::upper_first($strings[$i]);
            }
            else 
            {
                $return_string .= self::upper_first($strings[$i]);
            }
        }
        return $return_string;
    }
    
    public static function lower_file_name($string){
        $strings = explode("_", $string);
        $count = count($strings); 
        return strtolower($strings[$count - 1]);
    }
    
    public static function upper_first_file_name($string){ 
        return self::upper_first(self::lower_file_name($string));
    }
    
    
    public static function path_from_name($string, $num){
        $strings = explode("_", $string);
        $count = count($strings);   
        $return_string = "";
        for($i = 0; $i < $count-1; ++$i){
            $s = Generator_Util_Kohana::upper_first($num) ? Generator_Util_Text::upper_first($strings[$i]) : strtolower($strings[$i]);
            $return_string .= $s.DIRECTORY_SEPARATOR;
        }
        return $return_string;
    }
            
    /**
     * patched by alrusdi
     * thanks!
     */
    public static function space($num=0)
    {        
        return str_repeat(" ", $num);
    }
    
    public static function name($name){
        if('3.3.0' <= Kohana::VERSION){
            return self::upper_first($name);
        }else{
            return strtolower($name);
        }
    }
}

?>
