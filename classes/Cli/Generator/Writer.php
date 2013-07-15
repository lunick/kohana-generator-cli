<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Writer {
    
    protected $generated_file;
    protected $generated_backup;
    protected $error;
    protected $file;
    protected $dir;
    private $php_head = false;
    private $rows = array();
    
    public function add_row($row = "", $space_num = 0) {
        $this->rows[] = space($space_num) . $row . PHP_EOL;
        return $this;
    }
    
    public function get_rows_as_array(){
        return $this->rows;
    }
    
    public function get_rows_as_string() {
        $string = "";
        foreach ($this->rows as $row) {
            $string .= $row;
        }
        return $string;
    }
    
    public function php_head_enable(){
        $this->php_head = true;
        return $this;
    }
    
    public function php_head_disable(){
        $this->php_head = false;
        return $this;
    }
            
    public function set_file($file){
        $this->file = $file;
        return $this;
    }
    
    public function get_file(){
        return $this->file;
    }
    
    public function set_dir($dir){
        $this->dir = $dir;
        return $this;
    }
    
    public function get_dir(){
        return $this->dir;
    }
    
    public function get_generated_file(){
        return $this->generated_file;
    }
    
    public function get_generated_backup(){
        return $this->generated_backup;
    }
    
    public function get_error(){
        return $this->error;
    }
    
    public function has_generated_file(){
        return isset($this->generated_file) ? true : false;
    }
    
    public function has_generated_backup(){
        return isset($this->generated_backup) ? true : false;
    }
    
    public function has_error(){
        return isset($this->error) ? true : false;
    }
    
    public function file_exists(){
        return file_exists($this->get_dir().DIRECTORY_SEPARATOR.$this->get_file());
    }
    
    private function generate_rows(){
        $data = "";
        if($this->php_head)
        {
            $data .= Cli_Util_ConfigReader::get_key("start_php_file").PHP_EOL;
            $data .= "<?php".PHP_EOL;
            $data .= "/**".PHP_EOL;
            $data .= " * @package".PHP_EOL;
            $data .= " * @author " . Cli_Util_ConfigReader::get_key("author").PHP_EOL;
            $data .= " * @license " . Cli_Util_ConfigReader::get_key("license").PHP_EOL;
            $data .= " * @copyright (c) " . date("Y") . " " . Cli_Util_ConfigReader::get_key("author").PHP_EOL;
            $data .= " *".PHP_EOL;
            $data .= " */".PHP_EOL;
        }
            
        $data .= $this->get_rows_as_string();
        return $data;
    }

    private function put_contents($file){
        $result = file_put_contents($file, $this->generate_rows());
        if($result !== false)
        {
            $this->generated_file = $file;
        }
    }

    public function write($force = false, $backup = false){
        if(is_writable($this->get_dir()))
        {
            $file = $this->get_dir().DIRECTORY_SEPARATOR.$this->get_file();
            
            if (file_exists($file)) 
            { 
                if(!$force)
                {
                    $this->error = "File exists: " . $file." !";
                }
                
                if($backup)
                {
                    $backup = Cli_Util_Backup::backup($file);
                    $this->generated_backup = $backup;
                }
                
                if($force){
                    $this->put_contents($file);
                }
            }
            else
            { 
                $this->put_contents($file);
            }
        }
        else
        {
            $this->error = "Not writable: " . $this->get_dir() . " !";
        }
        
    }
}

?>
