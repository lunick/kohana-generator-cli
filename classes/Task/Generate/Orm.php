<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --table=dbtablename 
 *  --all=yes       default: --all=no
 *  --force=yes     default: --force=no
 *  --backup=yes    default: --backup=no
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_Orm extends Generator_Task {
    
    protected $_options = array(
        'table' => null,
        'all' => 'no',
        'force' => 'no',
        'backup' => 'no'
    );
          
    protected function _init(array $params) {        
        $table = empty($params['table']) ? null : $params['table'];
        $all = $params['all'] == 'yes' ? true : false;
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        if($all && empty($table))
        {
            $tables = Database::instance()->list_tables();
            foreach ($tables as $table){
                $this->add(
                        Generator_Orm::factory($table)
                            ->write($force, $backup)
                        );
            }
        }
        else if(!empty($table) && !$all)
        {
            $this->add(                
                    Generator_Orm::factory($table)
                        ->write($force, $backup)
                    );
        }
    }      
    
}

?>
