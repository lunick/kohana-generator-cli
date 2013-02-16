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
        $string = "dfsd_sdfsf_sdffsd_sfdf";
        echo Generator_Util_Text::upper_first($string).PHP_EOL;
        echo Generator_Util_Text::path_from_name($string).PHP_EOL;
    }    
}

?>
