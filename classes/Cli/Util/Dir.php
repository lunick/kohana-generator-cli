<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Util_Dir {
    
    private $files = array();
    private $dir = null;
    private $files_end_criteria = array();
    
    public static function factory(){
        return new Cli_Util_Dir();
    }
        
    private function read($dir_path){
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
                        $this->read($filepath);
                    }
                }
            }
            closedir($dh);
        }
        return $this;
    }
    
    private function file_end_in_criteria($path){
        foreach ($this->files_end_criteria as $end){
            if(end_with($path, $end))
            {
                return true;
            }
        }
        return false;
    }
    
    public function get_files(){
        $this->read($this->dir);
        return $this->files;
    }
    
    public function read_dir($dir){
        $this->dir = $dir;
        return $this;
    }
    
    public function set_file_end_criteria(array $array){
        $this->files_end_criteria = $array;
        return $this;
    }
    
}

?>
