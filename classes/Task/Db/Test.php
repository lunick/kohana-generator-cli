<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Db_Test extends Minion_Task {

    protected function _execute(array $params) {  
        echo PHP_EOL;
        try {
            Database::instance()->connect();
            echo Cli_Text::text('Connection: ok!'.PHP_EOL.PHP_EOL, Cli_Text::$green);
        }  catch (Exception $e){
            echo Cli_Text::text('Connection: failed!'.PHP_EOL.PHP_EOL, Cli_Text::$red);
        }
        
    }

}

?>
