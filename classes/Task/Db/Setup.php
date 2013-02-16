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
        
        $database = new Generator_Item_Database();
        $database->set_username($params['username'])
                ->set_password($params['password'])
                ->set_database($params['database']);
        
        try{
            Generator_File_Writer::factory($database)
                ->write($force, $backup);
        }catch(Exception $e){
            Generator_Cli_Help::nothing();
            echo Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
            Generator_Cli_Help::force($params);
            echo PHP_EOL;
        }
        
        echo PHP_EOL;
        try {
            Database::instance()->connect();
            echo Generator_Cli_Text::text('Connection: ok!'.PHP_EOL.PHP_EOL, Generator_Cli_Text::$green);
        }  catch (Exception $e){
            echo Generator_Cli_Text::text('Connection: failed!'.PHP_EOL.PHP_EOL, Generator_Cli_Text::$red);
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
