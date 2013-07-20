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
            if(isset($params[1]))
            {
                Cli_Help::print_help($params[1]);
            }
        }
    }   
    
    protected function _help(array $params) {
        print_info("Commands list: ");
        println_param("php index.php g");
        print_info("Or: ");
        println_param("php index.php command");
        println_param(char("-", 60));
        print_info("More info from the command: ");
        println_param("php index.php command shortname");
        print_info("For example: ");
        println_param("php index.php command db:s");
        print_info("For example: ");
        println_param("php index.php command g:c");
        print_info("For example: ");
        println_param("php index.php command g:as");
    }   
    
}

?>
