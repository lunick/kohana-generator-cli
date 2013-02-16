<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Util_File {
        
    public static function chmod($path){
        @chmod($path, Generator_Util_ConfigReader::get_key('chmod'));
    }
        
    public static function delete($path){
        self::chmod($path);
        @unlink($path);
    }
    
    public static function file_end_with($path, $end){
        $path_length = strlen($path);
        $end_length = strlen($end);
        $start = $path_length - $end_length;
        $end_string = substr($path, $start, $path_length);
        return $end_string === $end ? true : false;
    }
    
    public static function remove_all($dir_path){
        $dir_handle = opendir($dir_path);
        while(($file = readdir($dir_handle)) != false){
            if($file != "." && $file != ".."){
                $file_path = $dir_path.DIRECTORY_SEPARATOR.$file;
                @chmod($file_path, 0777);
                if(is_dir($file_path)){
                    self::remove_all($file_path);
                    if($file_path != Kohana::$cache_dir){
                        @rmdir($file_path);
                    }
                }else{
                    @unlink($file_path);
                }
            }
        }
        closedir($dir_handle);
    }
}

?>
