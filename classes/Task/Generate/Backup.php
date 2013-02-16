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
class Task_Generate_Backup extends Minion_Task {
    
    protected $_options = array(
        'dir' => null
    );
          
    protected function _execute(array $params) {
        if(!empty($params["dir"]))
        {
            Generator_Service_Backup::factory()
                    ->make_backup(Generator_Util_Kohana::paths_from_string($params["dir"]));
        }
        else
        {
            Generator_Service_Backup::factory()
                    ->make_backup(APPPATH);
            Generator_Service_Backup::factory()
                    ->make_backup(Generator_Util_Kohana::paths(Generator_Util_Kohana::$ASSETS));
        }
    }    
    
}

?>
