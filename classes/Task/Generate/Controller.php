<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --name=filename 
 *  --dir=subdirectory
 *  --action=actions    default: --action=index
 *  --force=yes         default: --force=no
 *  --backup=yes        default: --backup=no
 *  
 *  adding more action:
 *  --action=action1:action2:action3
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_Controller extends Minion_Task {
    
    protected $_options = array(
        'name' => null,
        'dir' => null,
        'action' => array(),
        'force' => 'no',
        'backup' => 'no'
    );
          
    protected function _execute(array $params) {        
        $name = empty($params['name']) ? "welcome" : $params['name'];
        $dir = empty($params['dir']) ? "" : $params['dir'];
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        $action = !empty($params['action']) ? array_unique(explode(':', $params['action'])) : array('index');
        
        if(!empty($dir)){ $name = $dir."_".$name; }
        
        try{
            $controller = new Generator_Item_Controller($name);
            $controller->set_actions($action);
            
            Generator_File_Writer::factory($controller)
                ->set_subdirectory($dir)
                ->write($force, $backup);
        }catch(Exception $e){
            Generator_Cli_Help::nothing();
            echo Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
            Generator_Cli_Help::force($params);
            echo PHP_EOL;
        }
    }    
    
    public function build_validation(\Validation $validation) {
        return parent::build_validation($validation)
                ->rule('name', 'not_empty');
    }
    
}

?>
