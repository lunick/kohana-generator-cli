<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --username=dbusername 
 *  --password=dbpassword
 *  --database=dbname
 *  --force=yes     default: --force=no
 *  --backup=yes    default: --backup=no
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Db_Setup extends Minion_Task {

    protected $_options = array(
        'username' => null,
        'password' => null,
        'database' => null,
        'force' => 'no',
        'backup' => 'no'
    );

    protected function _execute(array $params) {
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
                
        try{
            Generator_Database::factory($params['username'], $params['password'], $params['database'])
                ->write($force, $backup);
        }catch(Exception $e){
            Cli_Help::nothing();
            echo Cli_Text::text($e->getMessage(), Cli_Text::$red).PHP_EOL;
            Cli_Help::force($params);
            echo PHP_EOL;
        }
        
        echo PHP_EOL;
        try {
            Database::instance()->connect();
            echo Cli_Text::text('Connection: ok!'.PHP_EOL.PHP_EOL, Cli_Text::$green);
        }  catch (Exception $e){
            echo Cli_Text::text('Connection: failed!'.PHP_EOL.PHP_EOL, Cli_Text::$red);
        }
        
    }

    public function build_validation(\Validation $validation) {
        return parent::build_validation($validation)
                        ->rule('username', 'not_empty')
                        ->rule('password', 'not_empty')
                        ->rule('database', 'not_empty');
    }

}

?>
