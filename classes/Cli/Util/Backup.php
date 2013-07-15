<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Util_Backup {
    
    public static function factory(){
        return new Cli_Util_Backup();
    }

    public function make_backup($dir_path){
        $result = array();
        $files = Cli_Util_Dir::factory()
                ->set_file_end_criteria(array("php", "css", "js", "jpg", "jpeg", "png"))
                ->read_dir($dir_path)
                ->get_files();
       
        foreach ($files as $file){
            $result[] = self::backup($file);
        }
        return $result;
    }
    
    public function delete_backup($dir_path){
        $result = array();
        $files = Cli_Util_Dir::factory()
                ->set_file_end_criteria(
                        array("~","bak"
                        )
                )
                ->read_dir($dir_path)
                ->get_files();
       
        foreach ($files as $file){
            $result[] = delete_file($file);
        }
        return $result;
    }
    
    public static function backup($source){
        gchmod($source);
        $ext = pathinfo($source, PATHINFO_EXTENSION);
        $path = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        
        $date = date(Cli_Util_ConfigReader::get_key("backup_datetime_format"));
        $dest = strtoupper(substr(PHP_OS, 0, 3)) === "WIN" ? $path.DIRECTORY_SEPARATOR.$name.".".$date.".".$ext.".bak" : $path.DIRECTORY_SEPARATOR.$name.".".$date.".".$ext."~";
        @copy($source, $dest);
        gchmod($dest);
        return $dest;
    }
}

?>
