<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 *
 * It can accept the following options:
 *  --table=dbtablename 
 *  --dir=subdirectory
 *  --all=yes       default: --all=no
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
class Task_Generate_Crud extends Generator_Task {

    protected $_options = array(
        'table' => null,
        'dir' => null,
        'all' => 'no',
        'force' => 'no',
        'backup' => 'no'
    );

    protected function _init(array $params) {
        $table = empty($params['table']) ? null : $params['table'];
        $all = $params['all'] == 'yes' ? true : false;
        $dir = empty($params['dir']) ? null : $params['dir'];
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        if($all && empty($table))
        {
            $tables = Database::instance()->list_tables();
            foreach ($tables as $table){
                $this->add(
                        Generator_Crud::factory($table)
                            ->set_subdirectory($dir)                   
                            ->write($force, $backup)
                    );
            }
        }
        else if(!empty($table) && !$all)
        {
            $this->add(
                    Generator_Crud::factory($table)
                        ->set_subdirectory($dir)                   
                        ->write($force, $backup)
                    );
        }        
    }

}

?>
