<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Cli_Generator_Abstract_Service implements Cli_Generator_Interface_Service {
    
    private $options_obj;
    private $prompt_obj;
    
    public function __construct() {
        $this->prompt_obj = new Cli_Generator_Prompt();
        $this->options_obj = new Cli_Generator_Options();
        $this->prompt($this->prompt_obj, $this->options_obj);
        $this->options_obj->set_options($this->get_prompt_obj()->get_options());
    }
    
    /**
     * @return Cli_Generator_Options
     */
    public function get_options_obj() {
        return $this->options_obj;
    }
    
    /**
     * @return Cli_Generator_Interface_InteractivePrompt
     */
    public function get_prompt_obj() {
        return $this->prompt_obj;
    }
    
    /**
     * void method print to helps
     */
    public function help() {
        return false;
    }
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {}
}

?>
