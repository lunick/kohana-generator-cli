<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Service_Backup {
    
    public static function factory(){
        return new Generator_Service_Backup();
    }

    public function make_backup($dir_path){
        $files = Generator_Service_Dir::factory()
                ->set_file_end_criteria(array("php", "css", "js"))
                ->read_dir($dir_path)
                ->get_files();
       
        foreach ($files as $file){
            self::backup($file);
        }
    }
    
    public function delete_backup($dir_path){
        $files = Generator_Service_Dir::factory()
                ->set_file_end_criteria(
                        array("~","bak"
                        )
                )
                ->read_dir($dir_path)
                ->get_files();
       
        foreach ($files as $file){
            Generator_Util_File::delete($file);
        }
    }
    
    public static function backup($source){
        Generator_Util_File::chmod($source);
        $ext = pathinfo($source, PATHINFO_EXTENSION);
        
        $src = Generator_Service_Content::factory()
                ->set_text($source)
                ->search_string($ext)
                ->cut_before()
                ->get_text();
        
        $date = date(Generator_Util_ConfigReader::get_key("backup_datetime_format"));
        $dest = strtoupper(substr(PHP_OS, 0, 3)) === "WIN" ? $src.$date.".".$ext.".bak" : $src.$date.".".$ext."~";
        @copy($source, $dest);
        Generator_Util_File::chmod($dest);
    }
}

?>
