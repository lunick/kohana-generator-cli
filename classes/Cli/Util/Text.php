<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Util_Text {
    
    public static function upper_first($string)
    {
        return ucfirst(strtolower($string));
    }
    
    public static function class_name($string){
        $array1 = self::explode_string_underline($string); 
        $array2 = self::explode_string_separator($string);
        return count($array1) < count($array2) ? self::dir_separator_to_underline_upperfirst($string) : self::underline_normalize_upperfirst($string);
    }
    
    public static function lower_file_name($string){
        $strings = self::explode_string_underline($string); 
        $count = count($strings); 
        return strtolower($strings[$count - 1]);
    }
    
    public static function upper_first_file_name($string){ 
        return self::upper_first(self::lower_file_name($string));
    }
    
    public static function subdirectory_from_filename($string){
        $strings = self::explode_string_underline($string);
        $count = count($strings); 
        unset($strings[$count-1]);
        return self::array_separator_lowercase($strings);
    }
    
    public static function path_from_name($string, $num){
        $array = self::explode_string_underline($string); 
        $return_string = "";
        if(!empty($array)){
            foreach ($array as $item){
                $s = Cli_Util_System::upper_first($num) ? self::upper_first($item) : strtolower($item);
                $return_string .= $s.DIRECTORY_SEPARATOR;
            }
        }
        return $return_string;
    }
    
    public static function dir_separator_to_underline_lowercase($string){
        $array = self::explode_string_separator($string);
        return self::array_underline_lowercase($array);
    }
    
    public static function dir_separator_to_underline_upperfirst($string){
        $array = self::explode_string_separator($string);
        return self::array_underline_upperfirst($array);
    }
    
    public static function dir_separator_normalize_lowercase($string){
        $array = self::explode_string_separator($string);
        return self::array_separator_lowercase($array);
    }
    
    public static function dir_separator_normalize_upperfirst($string){
        $array = self::explode_string_separator($string);
        return self::array_separator_upperfirst($array);
    }
    
    public static function underline_normalize_lowercase($string){
        $array = self::explode_string_underline($string);
        return self::array_underline_lowercase($array);
    }
    
    public static function underline_normalize_upperfirst($string){
        $array = self::explode_string_underline($string);
        return self::array_underline_upperfirst($array);
    }
    
    private static function array_separator_upperfirst($array){
        $string = "";
        if(!empty($array)){
            $count = count($array);
            $i = 1;
            foreach ($array as $item){
                if($i < $count){
                    $string .= self::upper_first($item).DIRECTORY_SEPARATOR;
                }else{
                    $string .= self::upper_first($item);
                }
                ++$i;
            }
        }
        return $string;
    }
    
    private static function array_separator_lowercase($array){
        $string = "";
        if(!empty($array)){
            $count = count($array);
            $i = 1;
            foreach ($array as $item){
                if($i < $count){
                    $string .= strtolower($item).DIRECTORY_SEPARATOR;
                }else{
                    $string .= strtolower($item);
                }
                ++$i;
            }
        }
        return $string;
    }
    
    private static function array_underline_upperfirst($array){
        $string = "";
        if(!empty($array)){
            $count = count($array);
            $i = 1;
            foreach ($array as $item){
                if($i < $count){
                    $string .= self::upper_first($item)."_";
                }else{
                    $string .= self::upper_first($item);
                }
                ++$i;
            }
        }
        return $string;
    }
    
    private static function array_underline_lowercase($array){
        $string = "";
        if(!empty($array)){
            $count = count($array);
            $i = 1;
            foreach ($array as $item){
                if($i < $count){
                    $string .= strtolower($item)."_";
                }else{
                    $string .= strtolower($item);
                }
                ++$i;
            }
        }
        return $string;
    }
    
    public static function explode_string_separator($string){
        return array_filter(explode(DIRECTORY_SEPARATOR, $string));
    }
    
    public static function explode_string_underline($string){
        return array_filter(explode("_", $string));
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
