<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_File_Writer {
    
    private $builder;
    private $file;
    private $directory;
    private $subdirectory = null;
    
    public function __construct(Generator_Abstract_Item $item){
        $item->init();
        $item->init_name();
        $this->builder = $item->get_file_builder();
        $this->file = $this->builder->get_filename().".".$this->builder->get_ext();
        $this->directory = $this->builder->get_dir();
    }
    
    public static function factory(Generator_Abstract_Item $item){
        return new Generator_File_Writer($item);
    }
    
    public function file_exists(){
        return file_exists($this->get_dir_path().$this->get_file());
    }
    
    public function get_dir_path(){
        return !empty($this->subdirectory) ? $this->get_directory().$this->get_subdirectory() : $this->get_directory();
    }
    
    public function subdirectory_exists(){
        return file_exists($this->get_directory().DIRECTORY_SEPARATOR.$this->get_subdirectory());
    }
    
    public function directory_exists(){
        return file_exists($this->get_directory());
    }
    
    public function set_subdirectory($dirname){
        $this->subdirectory = $dirname.DIRECTORY_SEPARATOR;
        return $this;
    }
            
    public function get_subdirectory(){
        return $this->subdirectory;
    }
    
    public function get_directory(){
        return $this->directory;
    }
    
    public function get_file(){
        return $this->file;
    }
    
    public function get_file_path(){
        return $this->get_dir_path().$this->get_file();
    }
    
    public function get_filename(){
        return $this->builder->get_filename();
    }
    
    public function get_rows(){
        return $this->builder->get_rows();
    }
    
    public function write($force = false, $backup = false){
        $content = $this->builder->get_rows_as_string();
        if(!empty($content)){
            if(!$this->directory_exists())
            {
                Generator_Service_Dir::factory()
                        ->mkdir($this->get_dir_path());
            }

            if(!empty($this->subdirectory))
            {
                if(!$this->subdirectory_exists())
                {
                    Generator_Service_Dir::factory()
                            ->mkdir($this->get_dir_path());
                }
            }

            if(!$this->file_exists())
            {
                file_put_contents($this->get_file_path(), $content);
            }
            elseif ($this->file_exists())
            {
                if($backup)
                {
                    Generator_Service_Backup::backup($this->get_file_path());
                }
                if($force)
                {
                    file_put_contents($this->get_file_path(), $content);
                }
                else
                {
                    throw new Generator_Exception_FileExists($this);
                }
            }
        }
    }
}

?>
