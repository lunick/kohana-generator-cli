<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Service_Backup {
    
    public static function factory(){
        return new Cli_Service_Backup();
    }

    public function make_backup($dir_path){
        $result = array();
        $files = Cli_Service_Dir::factory()
                ->set_file_end_criteria(array("php", "css", "js"))
                ->read_dir($dir_path)
                ->get_files();
       
        foreach ($files as $file){
            $result[] = self::backup($file);
        }
        return $result;
    }
    
    public function delete_backup($dir_path){
        $result = array();
        $files = Cli_Service_Dir::factory()
                ->set_file_end_criteria(
                        array("~","bak"
                        )
                )
                ->read_dir($dir_path)
                ->get_files();
       
        foreach ($files as $file){
            $result[] = Cli_Util_File::delete($file);
        }
        return $result;
    }
    
    public static function backup($source){
        Cli_Util_File::chmod($source);
        $ext = pathinfo($source, PATHINFO_EXTENSION);
        $path = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        
        $date = date(Cli_Util_ConfigReader::get_key("backup_datetime_format"));
        $dest = strtoupper(substr(PHP_OS, 0, 3)) === "WIN" ? $path.DIRECTORY_SEPARATOR.$name.".".$date.".".$ext.".bak" : $path.DIRECTORY_SEPARATOR.$name.".".$date.".".$ext."~";
        @copy($source, $dest);
        Cli_Util_File::chmod($dest);
        return $dest;
    }
}

?>
