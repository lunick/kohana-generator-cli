<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_G extends Generator_Task {
    
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
