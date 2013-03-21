<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --force=yes     default: --force=no
 *  --backup=yes    default: --backup=no
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_Assets extends Generator_Task {

    protected $_options = array(
        'force' => 'no',
        'backup' => 'no'
    );
    
    protected function _init(array $params) {
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        $this->add(Generator_Jquery::factory("jquery.min")
                ->write($force, $backup));
            
        $this->add(
                Generator_KubeMaster::factory("master")
                    ->write($force, $backup)
                );
            
        $this->add(
                Generator_KubeMin::factory("kube.min")
                    ->write($force, $backup)
                );
            
        $this->add(
                Generator_Reset::factory("reset")
                    ->write($force, $backup)
                );
            
       Cli_Service_Dir::factory()
            ->mkdir("assets" . DIRECTORY_SEPARATOR . "img");
          
    }

    
}

?>
