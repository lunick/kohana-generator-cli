<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author burningface
 */
class Task_Test extends Minion_Task {
    
    protected function _execute(array $params) {
        $driver = new Cli_Database_Mysql_Driver();
        $table = "albums";
        
        foreach ($driver->relationship_result($table) as $field) {
            
                echo $field->get_column_name().PHP_EOL;

            
        }
        
    }    
    
}

?>
