<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Cli_Generator_Abstract_Controller extends Cli_Generator_Abstract_Template implements Cli_Generator_Interface_Controller {
    
    protected $actions = array();
         
    /**
     * 
     * @param array $actions
     * @return Cli_Generator_Interface_Controller
     */
    public function set_actions(array $actions){
        $this->actions = $actions;
        return $this;
    }

    /**
     * 
     * @return array
     */
    public function get_actions() {
        return $this->actions;
    }
}

?>
