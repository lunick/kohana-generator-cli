<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Generator_Interface_Service extends Cli_Generator_Interface_Help{
    
    /**
     * service run method
     */
    public function run();
    
    /**
     * @param Cli_Generator_Interface_InteractivePrompt $prompt, Cli_Generator_Interface_Options $options
     */
    public function prompt(Cli_Generator_Interface_InteractivePrompt $prompt, Cli_Generator_Interface_Options $options);
    
    /**
     * @return Cli_Generator_Options
     */
    public function get_options_obj();
    
    /**
     * @return Cli_Generator_Interface_InteractivePrompt
     */
    public function get_prompt_obj();
    
}

?>
