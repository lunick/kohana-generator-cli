<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Db_Table_List extends Minion_Task {
      
    protected function _execute(array $params) {
        $tables = Database::instance()->list_tables();
        Cli_Help::print_tables($tables);
    }    
    
}

?>
