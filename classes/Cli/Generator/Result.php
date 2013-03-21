<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Result {
    
    private $errors = array();
    private $generated_files = array();
    private $generated_backups = array();
    private $params = array();
    
    public static function factory(){
        return new Cli_Generator_Result();
    }
    
    public function get_errors() {
        return $this->errors;
    }

    public function add_error($error) {
        $this->errors[] = $error;
    }
    
    public function add_errors(array $errors) {
        $this->errors = array_merge($this->errors, $errors);
    }

    public function get_generated_files() {
        return $this->generated_files;
    }

    public function add_generated_file($generated_file) {
        $this->generated_files[] = $generated_file;
    }
    
    public function add_generated_files(array $generated_files) {
        $this->generated_files = array_merge($this->generated_files, $generated_files);
    }

    public function get_generated_backups() {
        return $this->generated_backups;
    }

    public function add_generated_backup($generated_backup) {
        $this->generated_backups[] = $generated_backup;
    }
    
    public function add_generated_backups(array $generated_backups) {
        $this->generated_backups = array_merge($this->generated_backups, $generated_backups);
    }
    
    public function get_params() {
        return $this->params;
    }

    public function set_params($params) {
        $this->params = $params;
        return $this;
    }
    
    public function add(Cli_Generator_Abstract_Generator_Item $item){
        $error = $item->get_error();
        $backup = $item->get_generated_backup();
        $generated_file = $item->get_generated_file();
        if(!empty($error)){ $this->add_error($error); }
        if(!empty($generated_file)){ $this->add_generated_file($generated_file); }
        if(!empty($backup)){ $this->add_generated_backup($backup); }
    }
    
    public function print_result(){
        Cli_Help::print_line(100, Cli_Text::$blue);
        if(!empty($this->errors))
        {
            echo Cli_Text::text("Errors:", Cli_Text::$red).PHP_EOL;
            foreach ($this->errors as $error){
                echo Cli_Text::text($error, Cli_Text::$red).PHP_EOL;
            }
            Cli_Help::force($this->get_params());
            Cli_Help::print_line(100, Cli_Text::$blue);
        }
        
        if(!empty($this->generated_backups))
        {
            echo Cli_Text::text("Generated Backups:", Cli_Text::$green).PHP_EOL;
            foreach ($this->generated_backups as $file){
                echo Cli_Text::text($file, Cli_Text::$green).PHP_EOL;
            }
            Cli_Help::print_line(100,Cli_Text::$blue);
        }
        
        if(!empty($this->generated_files))
        {
            echo Cli_Text::text("Generated Files:", Cli_Text::$green).PHP_EOL;
            foreach ($this->generated_files as $file){
                echo Cli_Text::text($file, Cli_Text::$green).PHP_EOL;
            }
            Cli_Help::print_line(100, Cli_Text::$blue);
        }
        
    }

}

?>
