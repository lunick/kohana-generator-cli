<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --name=viewnames
 *  --dir=subdirectory
 *  --force=yes     default: --force=no
 *  --backup=yes    default: --backup=no
 * 
 *  adding more view:
 *  --name=view1:view2:view3
 * 
 *  adding more subdirectory
 *  --dir=dir1/dir2/dir3
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_View extends Generator_Task {
    
    protected $_options = array(
        'name' => null,
        'dir' => null,
        'force' => 'no',
        'backup' => 'no'
    );

    protected function _init(array $params) {        
        $names = explode(':', $params['name']);
        $dir = empty($params['dir']) ? "templates" : $params['dir'];
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        foreach($names as $name){
            $this->add(
                    Generator_EmptyView::factory($name)
                        ->set_subdirectory($dir)
                        ->write($force, $backup)
                    );
        }
    }
    
    public function build_validation(\Validation $validation) {
        return parent::build_validation($validation)
                ->rule('name', 'not_empty');
    }
    
}

?>
