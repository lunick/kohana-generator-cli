<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Generator_Interface_Options {
    
    /**
     * 
     * @param var $name
     * @param var $value
     * @throws Exception
     */
    public function __set($name, $value); 
    
    /**
     * 
     * @param var $name
     * @return boolean
     */
    public function __isset($name); 
    
    /**
     * 
     * @param string $name
     * @return var
     */
    public function __get($name);
    
    /**
     * 
     * @param array $options
     * @return Cli_Generator_Options
     */
    public function set_options(array $options);
            
    /**
     * 
     * @return array
     */
    public function get_options();
    
    /**
     * 
     * @param string $skip_key
     * @return boolean
     */
    public function is_skip($skip_key);
    
    /**
     * 
     * @param string $key
     * @param string $skip_key
     * @param var $value
     * @return Cli_Generator_Options 
     */
    public function add_skip($key, $skip_key, $value);
}

?>
