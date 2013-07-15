<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Generator_Interface_Template extends Cli_Generator_Interface_Help {
    
    /**
     * @param Cli_Generator_Interface_InteractivePrompt $prompt, Cli_Generator_Interface_Options $options
     */
    public function prompt(Cli_Generator_Interface_InteractivePrompt $prompt, Cli_Generator_Interface_Options $options);
    
    /**
     * template initialization method
     */
    public function init();
        
    /**
    * @param string
    * @return $this
    */
    public function set_name($name);
    
    /**
     * @return string
     */
    public function get_name();
    
    /**
     * @return boolean
     */
    public function has_name();
    
    /**
     * @param string
     * @return $this
     */
    public function set_subdir($dir);
       
    /**
     * @return string
     */
    public function get_subdir();
    
    /**
     * @return boolean
     */
    public function has_subdir();
    
    /**
     * @return Cli_Generator_Options
     */
    public function get_options_obj();
    
    /**
     * @return Cli_Generator_Interface_InteractivePrompt
     */
    public function get_prompt_obj();
    
    /**
     * @param Cli_Generator_Writer $writer
     */
    public function add_writer(Cli_Generator_Writer $writer);
    
    /**
     * @return Cli_Generator_Writer
     */
    public function get_new_writer();
    
    /**
     * @return array Cli_Generator_Writer array
     */
    public function get_writers();
            
}

?>
