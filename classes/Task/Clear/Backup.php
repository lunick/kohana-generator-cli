<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --dir=option
 *  
 *  options:
 *      --dir=js
 *      --dir=css
 *      --dir=img
 *      --dir=assets
 *      --dir=controller
 *      --dir=model
 *      --dir=config
 *      --dir=i18n
 *      --dir=logs
 *      --dir=messages
 *      --dir=views
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Clear_Backup extends Minion_Task {
    
    protected $_options = array(
        'dir' => null
    );
          
    protected function _execute(array $params) {
        if(isset($params["dir"])){
            Cli_Service_Backup::factory()
                    ->delete_backup(Cli_Util_System::paths_from_string($params["dir"]));
        }else{
            Cli_Service_Backup::factory()
                    ->delete_backup(APPPATH);
            Cli_Service_Backup::factory()
                    ->delete_backup(Cli_Util_System::paths(Cli_Util_System::$ASSETS));
        }
    }    
    
}

?>
