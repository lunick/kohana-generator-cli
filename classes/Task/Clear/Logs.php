<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Clear_Logs extends Minion_Task {
              
    protected function _execute(array $params) {
        Cli_Util_File::remove_all(Cli_Util_System::paths(Cli_Util_System::$LOGS));
    }    
    
}

?>
