<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Cli_Generator_Abstract_Template implements Cli_Generator_Interface_Template {
    
    private $subdir;
    private $name;
    private $options_obj;
    private $prompt_obj;
    private $writers = array(); 
    
    public function __construct() {
        $accepted = "yes|no|y|n";
        $this->prompt_obj = new Cli_Generator_Prompt();
        $this->options_obj = new Cli_Generator_Options();
        $this->prompt($this->prompt_obj, $this->options_obj);
        $this->prompt_obj
                ->add_prompt("force", lang(array("force", "yn", "skip")), $accepted, false)
                ->add_prompt("backup", lang(array("backup", "yn", "skip")), $accepted, false);
        $this->options_obj->set_options($this->get_prompt_obj()->get_options());
    }
    
    /**
     * @return Cli_Generator_Interface_Template
     */
    public function set_subdir($subdir){
        $this->subdir = $subdir;
        return $this;
    }
    
    /**
     * @return string
     */
    public function get_subdir(){
        return $this->subdir.DIRECTORY_SEPARATOR;
    }
    
    /**
     * @return boolean
     */
    public function has_subdir(){
        return isset($this->subdir);
    }
    
    /**
     * @return this
     */
    public function set_name($name){
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function get_name(){
        return $this->name;
    }
    
    /**
     * @return boolean
     */
    public function has_name(){
        return isset($this->name);
    }
    
    /**
     * @return Cli_Generator_Options
     */
    public function get_options_obj() {
        return $this->options_obj;
    }
    
    /**
     * @return array
     */
    public function get_writers() {
        return $this->writers;
    }

    /**
     * @return Cli_Generator_Interface_Template
     */
    public function add_writer(\Cli_Generator_Writer $writer) {
        $this->writers[] = $writer;
        return $this;
    }
    
    /**
     * @return Cli_Generator_Interface_InteractivePrompt
     */
    public function get_prompt_obj() {
        return $this->prompt_obj;
    }
    
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {}
    
    /**
     * void method print to helps
     */
    public function help() {
        return false;
    }
        
    /**
     * 
     * @return \Cli_Generator_Writer
     */
    public function get_new_writer() {
        return new Cli_Generator_Writer();
    }
}

?>
