<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Generator_Interface_InteractivePrompt {
    
    /**
     * @param string $key, string $prompt_string, string $accepted_string, var default
     * @return Cli_Generator_Prompt
     */
    public function add_prompt($key, $prompt_string, $accepted_string=null, $default=null);
    
    /**
     * @param string $key
     * @return string
     */
    public function get_prompt($key);
        
    /**
     * @param string $key
     * @return string
     */
    public function get_accepted($key);
    
    /**
     * @param string $key
     * @return Cli_Generator_Prompt
     */
    public function add_more($key);
    
    /**
     * @param string $key
     * @return boolean
     */
    public function get_more($key);
    
    /**
     * @return array
     */
    public function get_options();
        
}

?>
