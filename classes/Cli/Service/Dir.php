<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Service_Dir {
    
    private $files = array();
    private $files_end_criteria = array();
    
    public static function factory(){
        return new Cli_Service_Dir();
    }
        
    public function read_dir($dir_path){
        if(file_exists($dir_path)){
            $dh = opendir($dir_path);
            while(($file = readdir($dh)) != false){
                if($file != '.' && $file != '..')
                {
                    $filepath = $dir_path.DIRECTORY_SEPARATOR.$file;

                    if(!is_dir($filepath))
                    {
                        if(empty($this->files_end_criteria))
                        {
                            $this->files[] = $filepath;
                        }
                        else
                        {
                            if($this->file_end_in_criteria($filepath))
                            {
                                $this->files[] = $filepath;
                            }
                        }

                    }
                    elseif (is_dir($filepath)) 
                    {
                        $this->read_dir($filepath);
                    }
                }
            }
            closedir($dh);
        }
        return $this;
    }
    
    private function file_end_in_criteria($path){
        foreach ($this->files_end_criteria as $end){
            if(Cli_Util_File::file_end_with($path, $end))
            {
                return true;
            }
        }
        return false;
    }
    
    public function get_files(){
        return $this->files;
    }
    
    public function set_file_end_criteria(array $array){
        $this->files_end_criteria = $array;
        return $this;
    }
     
    public function mkdir($dir_path){
        $text = Cli_Service_Content::factory()
                    ->search_string(DOCROOT)
                    ->set_text($dir_path)
                    ->cut_after()
                    ->get_text();
        
        $dirs = explode(DIRECTORY_SEPARATOR, $text);
        $path = DOCROOT;
        
        foreach ($dirs as $dir) {
            if(!empty($dir))
            {
                $path .= $dir.DIRECTORY_SEPARATOR;
                
                if (!file_exists($path)) 
                {
                    @mkdir($path);
                    Cli_Util_File::chmod($path);
                } 
            }
        }        
        return $this;
    }
    
}

?>
