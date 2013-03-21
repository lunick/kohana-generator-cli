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
 * adding more subdirectory
 *  --dir=dir1/dir2/dir3
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_View_Template extends Generator_Task {

    protected $_options = array(
        'name' => null,
        'dir' => null,
        'force' => 'no',
        'backup' => 'no'
    );

    protected function _init(array $params) {        
        $name = empty($params['name']) ? "template" : $params['name'];
        $dir = empty($params['dir']) ? "templates" : $params['dir'];
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        $this->add(
                Generator_Template::factory($name)
                    ->set_subdirectory($dir)
                    ->write($force, $backup)
                );
    }

}

?>
