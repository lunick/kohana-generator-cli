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
        Generator_Util_File::remove_all(Generator_Util_Kohana::paths(Generator_Util_Kohana::$LOGS));
    }    
    
}

?>
