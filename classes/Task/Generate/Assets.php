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
class Task_Generate_Assets extends Minion_Task {

    protected $_options = array(
        'force' => 'no',
        'backup' => 'no'
    );
    
    protected function _execute(array $params) {
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        try{
            Generator_File_Writer::factory(new Generator_Item_Jquery("jquery.min"))
                ->write($force, $backup);
            
            Generator_File_Writer::factory(new Generator_Item_KubeMaster("master"))
                ->write($force, $backup);
            
            Generator_File_Writer::factory(new Generator_Item_KubeMin("kube.min"))
                ->write($force, $backup);
            
            Generator_File_Writer::factory(new Generator_Item_Reset("reset"))
                ->write($force, $backup);
            
            Generator_Service_Dir::factory()
                ->mkdir("assets" . DIRECTORY_SEPARATOR . "img");
            
        }catch(Exception $e){
            Generator_Cli_Help::nothing();
            echo Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
            Generator_Cli_Help::force($params);
            echo PHP_EOL;
        }
    }

    
}

?>
