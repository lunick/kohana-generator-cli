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
class Task_Generate_Backup extends Generator_Task {
    
    protected $_options = array(
        'dir' => null
    );
          
    protected function _init(array $params) {
        if(!empty($params["dir"]))
        {
            $this->result->add_generated_backups(
                        Cli_Service_Backup::factory()
                            ->make_backup(Cli_Util_System::paths_from_string($params["dir"]))
                    );
        }
        else
        {
            $this->result->add_generated_backups(
                        Cli_Service_Backup::factory()
                            ->make_backup(APPPATH)
                    );
            $this->result->add_generated_backups(
                        Cli_Service_Backup::factory()
                            ->make_backup(Cli_Util_System::paths(Cli_Util_System::$ASSETS))
                    );
        }
    }    
    
}

?>
