<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Result {
    
    private $params = array();
    private $errors = array();
    private $generated_files = array();
    private $generated_backups = array();
    private $callbacks = array();
    
    public static function factory(){
        return new Cli_Generator_Result();
    }
    
    public function set_params($params){
        $this->params = $params;
        return $this;
    }

    public function get_params(){
        return $this->params;
    }

    public function get_errors() {
        return $this->errors;
    }

    public function add_callback($callback, $params = array()) {
        $this->callbacks[] = array("callable" => $callback, "params" => $params);
        return $this;
    }
    
    public function add_error($error) {
        $this->errors[] = $error;
        return $this;
    }
    
    public function add_errors(array $errors) {
        $this->errors = array_merge($this->errors, $errors);
        return $this;
    }

    public function get_generated_files() {
        return $this->generated_files;
    }

    public function add_generated_file($generated_file) {
        $this->generated_files[] = $generated_file;
        return $this;
    }
    
    public function add_generated_files(array $generated_files) {
        $this->generated_files = array_merge($this->generated_files, $generated_files);
        return $this;
    }

    public function get_generated_backups() {
        return $this->generated_backups;
        return $this;
    }

    public function add_generated_backup($generated_backup) {
        $this->generated_backups[] = $generated_backup;
        return $this;
    }
    
    public function add_generated_backups(array $generated_backups) {
        $this->generated_backups = array_merge($this->generated_backups, $generated_backups);
        return $this;
    }
    
    public function add(Cli_Generator_Writer $item){
        $error = $item->get_error();
        $backup = $item->get_generated_backup();
        $generated_file = $item->get_generated_file();
        if(!empty($error)){ $this->add_error($error); }
        if(!empty($generated_file)){ $this->add_generated_file($generated_file); }
        if(!empty($backup)){ $this->add_generated_backup($backup); }
        return $this;
    }
    
    public function print_result(){
        if(!empty($this->errors))
        {
            $this->errors = array_unique($this->errors);
            foreach ($this->errors as $error){
                println_error(clean_path($error));
            }
        }
        
        if(!empty($this->generated_backups))
        {
            $this->generated_backups = array_unique($this->generated_backups);
            println_info(Cli_Help::box(lang(array("generated_backup")).":"));
            Cli_Help::generated($this->generated_backups);
        }
        
        if(!empty($this->generated_files))
        {
            $this->generated_files = array_unique($this->generated_files);
            println_info(Cli_Help::box(lang(array("generated_files")).":"));
            Cli_Help::generated($this->generated_files);
        }
        
        if(!empty($this->callbacks)){
            $this->callbacks = array_unique($this->callbacks);
            foreach ($this->callbacks as $callback){
                if(isset($callback["callable"]) && isset($callback["params"]))
                {
                    call_user_func($callback["callable"], $callback["params"]);
                }
            }
        }
        
    }

}

?>
