<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Generator_Interface_Controller {
        
    /**
     * 
     * @param array $actions
     * @return Cli_Generator_Interface_Controller
     */
    public function set_actions(array $actions); 
    
    /**
     * 
     * @return array
     */
    public function get_actions(); 
}

?>
