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
class Task_Generate_Orm_Model extends Minion_Task {
    
    protected $_options = array(
        'table' => null,
        'all' => 'no',
        'force' => 'no',
        'backup' => 'no'
    );
          
    protected function _execute(array $params) {        
        $table = empty($params['table']) ? null : $params['table'];
        $all = $params['all'] == 'yes' ? true : false;
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        
        if($all && empty($table))
        {
            $tables = Database::instance()->list_tables();
            foreach ($tables as $table){
                try{
                    Generator_File_Writer::factory(new Generator_Item_Orm($table))
                        ->set_subdirectory(Generator_Util_Text::path_from_name($table, Generator_Util_Kohana::$MODEL))
                        ->write($force, $backup);
                }catch(Exception $e){
                    echo PHP_EOL.Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
                    Generator_Cli_Help::force($params);
                    echo PHP_EOL;
                }
            }
        }
        else if(!empty($table) && !$all)
        {
            try{
                Generator_File_Writer::factory(new Generator_Item_Orm($table))
                    ->write($force, $backup);
            }catch(Exception $e){
                Generator_Cli_Help::nothing();
                echo Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
                Generator_Cli_Help::force($params);
                echo PHP_EOL;
            }
        }
        else
        {
            Generator_Cli_Help::nothing();
            Generator_Cli_Help::options($params);
        }
    }      
    
}

?>
