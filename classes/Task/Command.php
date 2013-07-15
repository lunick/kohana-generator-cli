<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Command extends Minion_Task {
    
    protected function _execute(array $params) {
        if(empty($params))
        {
            Cli_Help::print_commands();
        }
        else
        {
            if(isset($params[1])){
                Cli_Help::print_help($params[1]);
            }
        }
    }    
    
}

?>
