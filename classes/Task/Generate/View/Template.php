<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --name=templatename
 *  --dir=subdirectory
 *  --force=yes     default: --force=no
 *  --backup=yes    default: --backup=no
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_View_Template extends Minion_Task {

    protected $_options = array(
        'name' => null,
        'dir' => null,
        'force' => 'no',
        'backup' => 'no'
    );

    protected function _execute(array $params) {        
        $name = empty($params['name']) ? "template" : $params['name'];
        $dir = empty($params['dir']) ? "templates" : $params['dir'];
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        try{
            Generator_File_Writer::factory(new Generator_Item_Template($name))
                ->set_subdirectory($dir)
                ->write($force, $backup);
        }catch(Exception $e){
            Generator_Cli_Help::nothing();
            echo Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
            Generator_Cli_Help::force($params);
            echo PHP_EOL;
        }
    }

}

?>
