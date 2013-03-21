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
class Task_Generate_I18n extends Generator_Task {
    
    protected $_options = array(
        'name' => null,
        'force' => 'no',
        'backup' => 'no'
    );
          
    protected function _init(array $params) {
        $force = $params['force'] == 'yes' ? true : false;
        $backup = $params['backup'] == 'yes' ? true : false;
        $names = explode(':', $params['name']);
        
        if(!empty($names)){
            foreach($names as $name){
                $this->add(
                        Generator_I18n::factory($name)
                            ->write($force, $backup)
                        );                               
            }
            $this->add(
                    Generator_Message::factory('validation')
                        ->write(true, true)
                    );  
        }
    }    
    
    public function build_validation(\Validation $validation) {
        return parent::build_validation($validation)
                ->rule('name', 'not_empty');
    }
    
}

?>
