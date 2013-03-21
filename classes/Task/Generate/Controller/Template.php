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
 * adding more subdirectory
 *  --dir=dir1/dir2/dir3
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_Controller_Template extends Generator_Task {
    
    protected $_options = array(
        'name' => null,
        'dir' => null,
        'action' => array(),
        'views' => 'yes',
        'force' => 'no',
        'backup' => 'no',
    );
          
    protected function _init(array $params) {
        $name = empty($params['name']) ? "welcome" : $params['name'];
        $dir = empty($params['dir']) ? "" : $params['dir'];
        $views = $params['views'] == 'yes' ? true : false;
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        $action = !empty($params['action']) ? array_unique(explode(':', $params['action'])) : array('index');
        
        $view_dir = !empty($dir) ? $dir.DIRECTORY_SEPARATOR.$name : $name.DIRECTORY_SEPARATOR;
        
        $this->add(
                Generator_TemplateController::factory($name)
                    ->set_actions($action)
                    ->set_subdirectory($dir)
                    ->set_with_views($views)
                    ->set_view_dir($view_dir)
                    ->write($force, $backup)
                );
            
            if($views){
                foreach($action as $view){
                    $this->add(
                            Generator_EmptyView::factory($view)
                                ->set_subdirectory($view_dir)
                                ->write($force, $backup)
                            );
                }
            }
    }    
    
    public function build_validation(\Validation $validation) {
        return parent::build_validation($validation)
                ->rule('name', 'not_empty');
    }
    
}

?>
