<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 *
 * It can accept the following options:
 *  --name=lang
 *  --force=yes     default: --force=no
 *  --backup=yes    default: --backup=no
 *  
 *  adding more lang:
 *  --name=lang1:lang2:lang3
 * 
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Task_Generate_I18n extends Minion_Task {
    
    protected $_options = array(
        'name' => null,
        'force' => 'no',
        'backup' => 'no'
    );
          
    protected function _execute(array $params) {
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        $names = explode(':', $params['name']);
        
        if(!empty($names)){
            foreach($names as $name){
                
                try{
                    Generator_File_Writer::factory(new Generator_Item_I18n($name))
                        ->write($force, $backup);
                }catch(Exception $e){
                    Generator_Cli_Help::nothing();
                    echo Generator_Cli_Text::text($e->getMessage(), Generator_Cli_Text::$red).PHP_EOL;
                    Generator_Cli_Help::force($params);
                    echo PHP_EOL;
                }
                
            }
            Generator_File_Writer::factory(new Generator_Item_Message('validation'))
                    ->write(true, true);
        }
    }    
    
    public function build_validation(\Validation $validation) {
        return parent::build_validation($validation)
                ->rule('name', 'not_empty');
    }
    
}

?>
